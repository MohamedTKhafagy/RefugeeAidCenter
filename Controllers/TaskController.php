<?php
require_once __DIR__ . '/../Models/Task.php';
require_once __DIR__ . '/../Models/Commands/AssignVolunteerCommand.php';
require_once __DIR__ . '/../Views/TaskListView.php';

class TaskController
{
    public function index()
    {
        $tasks = [];
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Tasks WHERE is_deleted = 0";
        $results = $db->fetchAll($sql);

        foreach ($results as $result) {
            $tasks[] = new Task(
                $result['name'],
                $result['description'],
                $result['hours_of_work'],
                $result['status'],
                $result['event_id'],
                $result['volunteer_id'],
                $result['id']
            );
        }

        $view = new TaskListView($tasks);
        echo $view->render();
    }

    public function add($data = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task = new Task(
                $data['Name'],
                $data['Description'],
                $data['HoursOfWork'],
                'pending',
                null,
                null
            );

            if ($task->save()) {
                // Add skills if provided
                if (!empty($data['skills'])) {
                    $db = DbConnection::getInstance();
                    foreach ($data['skills'] as $index => $skillName) {
                        if (empty($skillName)) continue;

                        // First ensure the skill exists in the Skills table
                        $sql = "INSERT IGNORE INTO Skills (name, category_id) 
                               SELECT ?, id FROM SkillCategories WHERE name = ?";
                        $db->query($sql, [$skillName, $skillName]);

                        // Get the skill ID
                        $sql = "SELECT id FROM Skills WHERE name = ?";
                        $result = $db->fetchAll($sql, [$skillName]);
                        if (!empty($result)) {
                            // Add the skill
                            $task->addSkill($result[0]['id']);
                        }
                    }
                }
                $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
                header('Location: ' . $base_url . '/tasks');
                exit;
            }
        }

        include __DIR__ . '/../Views/AddTaskView.php';
    }

    public function edit($id)
    {
        $task = Task::findById($id);
        if ($task) {
            include __DIR__ . '/../Views/EditTaskView.php';
        } else {
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/tasks');
            exit;
        }
    }

    public function update($data)
    {
        if (isset($data['Id'])) {
            $task = Task::findById($data['Id']);
            if ($task) {
                $task->setName($data['Name']);
                $task->setDescription($data['Description']);
                $task->setHoursOfWork($data['HoursOfWork']);

                if ($task->save()) {
                    // Update skills if provided
                    if (!empty($data['skills'])) {
                        // First remove existing skills
                        $db = DbConnection::getInstance();
                        $db->query("DELETE FROM Task_Skills WHERE task_id = ?", [$task->getId()]);

                        // Add new skills
                        foreach ($data['skills'] as $index => $skillName) {
                            if (empty($skillName)) continue;

                            // Find or create the skill
                            $skill = Skill::findByName($skillName);
                            if (!$skill) {
                                $skill = new Skill($skillName, $skillName, 'Skill for ' . $skillName);
                                $skill->save();
                            }

                            // Add the skill to the task
                            $task->addSkill($skill->getId());
                        }
                    }

                    $_SESSION['success'] = "Task updated successfully";
                } else {
                    $_SESSION['error'] = "Failed to update task";
                }
            } else {
                $_SESSION['error'] = "Task not found";
            }
        }

        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/tasks');
        exit;
    }

    public function delete($id)
    {
        $task = Task::findById($id);
        if ($task) {
            $db = DbConnection::getInstance();
            $db->query("UPDATE Tasks SET is_deleted = 1 WHERE id = ?", [$id]);
        }
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/tasks');
        exit;
    }

    public function assign($taskId, $volunteerId = null)
    {
        $task = Task::findById($taskId);
        if (!$task) {
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/tasks');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['volunteer_id'])) {
            $command = new AssignVolunteerCommand($task, $_POST['volunteer_id']);
            $command->execute();
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/tasks');
            exit;
        }

        $volunteers = Volunteer::all();
        require 'Views/AssignVolunteerView.php';
    }

    public function complete($taskId)
    {
        $task = Task::findById($taskId);
        if ($task) {
            // Only allow completion if task has a volunteer assigned
            if (!$task->getVolunteerId()) {
                $_SESSION['error'] = "Cannot complete task: No volunteer assigned";
                $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
                header('Location: ' . $base_url . '/tasks');
                exit;
            }

            try {
                // Use the state pattern to transition to the next state
                $task->nextState();
                if ($task->save()) {
                    $_SESSION['success'] = "Task state updated successfully to: " . $task->getCurrentState();
                } else {
                    $_SESSION['error'] = "Failed to update task state";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }
        } else {
            $_SESSION['error'] = "Task not found";
        }

        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/tasks');
        exit;
    }
}
