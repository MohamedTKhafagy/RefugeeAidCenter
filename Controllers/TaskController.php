<?php
require_once __DIR__ . '/../Models/Task.php';
require_once __DIR__ . '/../Models/Commands/AssignVolunteerCommand.php';
require_once __DIR__ . '/../Models/Commands/TaskDetailsCommand.php';
require_once __DIR__ . '/../Models/TaskCreationWizard.php';
require_once __DIR__ . '/../Views/TaskListView.php';
require_once __DIR__ . '/../Views/VolunteerTaskListView.php';
require_once __DIR__ . '/../Views/TaskWizard/DetailsView.php';
require_once __DIR__ . '/../Views/TaskWizard/EventView.php';
require_once __DIR__ . '/../Views/TaskWizard/ReviewView.php';
require_once __DIR__ . '/../Event.php';
require_once __DIR__ . '/../Models/Commands/AssignEventCommand.php';

class TaskController
{
    private $wizard;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->wizard = TaskCreationWizard::getInstance();
    }

    private function checkAdminAccess()
    {
        // if (
        //     !isset($_SESSION['user']) ||
        //     !isset($_SESSION['user']['type']) ||
        //     $_SESSION['user']['type'] !== 'admin'
        // ) {
        //     $_SESSION['error'] = "Access denied. Admin privileges required.";
        //     header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/login');
        //     exit;
        // }
    }

    public function index()
    {
        $this->checkAdminAccess();
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



    public function volunteerindex()
    {

        // session_start();
        $id = $_SESSION['user']['id'];
        $tasks = [];
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Tasks WHERE  volunteer_id = $id AND is_deleted = 0";
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
//
        $view = new VolunteerTaskListView($tasks);
        echo $view->render();
    }

    public function startWizard()
    {
        $this->checkAdminAccess();
        $this->wizard->reset();
        $view = new TaskWizardDetailsView($this->wizard);
        echo $view->render();
    }

    public function wizardDetails()
    {
        $this->checkAdminAccess();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task = $this->wizard->getTask();
            $command = new TaskDetailsCommand($task, [
                'name' => $_POST['Name'],
                'description' => $_POST['Description'],
                'hoursOfWork' => $_POST['HoursOfWork'],
                'skills' => $_POST['skills']
            ]);

            if ($this->wizard->executeCommand($command)) {
                $this->wizard->nextState();
                header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/tasks/wizard/event');
                exit;
            }
        }

        $view = new TaskWizardDetailsView($this->wizard);
        echo $view->render();
    }

    public function wizardEvent()
    {
        $this->checkAdminAccess();
        // Get available events first
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Events WHERE date >= CURDATE() AND is_deleted = 0";
        $results = $db->fetchAll($sql);

        $events = [];
        foreach ($results as $event) {
            $events[] = new Event(
                $event['id'],
                $event['name'],
                $event['location'],
                $event['type'],
                $event['max_capacity'],
                $event['current_capacity'],
                $event['date'],
                [], // volunteers array
                []  // attendees array
            );
        }

        // If no events are available, redirect to event creation
        if (empty($events)) {
            $_SESSION['error'] = "Please create an event first before creating a task.";
            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/events/add');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['event_id']) || empty($_POST['event_id'])) {
                $_SESSION['error'] = "Please select an event for this task.";
                $view = new TaskWizardEventView($this->wizard, $events);
                echo $view->render();
                return;
            }

            $task = $this->wizard->getTask();

            // Save the task first if it hasn't been saved yet
            if (!$task->getId()) {
                $db = DbConnection::getInstance();
                $sql = "INSERT INTO Tasks (name, description, hours_of_work, status) 
                        VALUES (?, ?, ?, 'pending')";
                $result = $db->query($sql, [
                    $task->getName(),
                    $task->getDescription(),
                    $task->getHoursOfWork()
                ]);

                if ($result) {
                    $task->setId($db->lastInsertId());

                    // Save skills
                    $skills = $task->getSkills();
                    if (!empty($skills)) {
                        foreach ($skills as $skill) {
                            $sql = "INSERT INTO TaskSkills (task_id, name) VALUES (?, ?)";
                            $db->query($sql, [$task->getId(), $skill['name']]);
                        }
                    }
                } else {
                    $_SESSION['error'] = "Failed to save task details";
                    $view = new TaskWizardEventView($this->wizard, $events);
                    echo $view->render();
                    return;
                }
            }

            try {
                $command = new AssignEventCommand($task, $_POST['event_id']);
                if ($this->wizard->executeCommand($command)) {
                    // Debug: Check if event ID is set after command execution
                    $db = DbConnection::getInstance();
                    $sql = "SELECT event_id FROM Tasks WHERE id = ?";
                    $result = $db->fetchAll($sql, [$task->getId()]);
                    if (!empty($result)) {
                        $_SESSION['debug'] = "Task ID: " . $task->getId() . ", Event ID in DB: " . $result[0]['event_id'] . ", Event ID in object: " . $task->getEventId();
                    }

                    $this->wizard->nextState();
                    header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/tasks/wizard/review');
                    exit;
                } else {
                    $_SESSION['error'] = "Failed to assign event to task.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }
        }

        $view = new TaskWizardEventView($this->wizard, $events);
        echo $view->render();
    }

    public function wizardReview()
    {
        $this->checkAdminAccess();
        $task = $this->wizard->getTask();
        $event = null;

        // Debug: Log task and event information
        $_SESSION['debug'] .= "\nReview - Task ID: " . $task->getId() . ", Event ID: " . $task->getEventId();

        if ($task->getEventId()) {
            $db = DbConnection::getInstance();
            $sql = "SELECT * FROM Events WHERE id = ? AND is_deleted = 0";
            $result = $db->fetchAll($sql, [$task->getEventId()]);

            // Debug: Log event query results
            $_SESSION['debug'] .= "\nEvent Query Results: " . (!empty($result) ? "Found" : "Not Found");

            if (!empty($result)) {
                $event = new Event(
                    $result[0]['id'],
                    $result[0]['name'],
                    $result[0]['location'],
                    $result[0]['type'],
                    $result[0]['max_capacity'],
                    $result[0]['current_capacity'],
                    $result[0]['date'],
                    [], // volunteers array
                    []  // attendees array
                );
                // Debug: Log created event object
                $_SESSION['debug'] .= "\nEvent Object Created - ID: " . $event->getId() . ", Name: " . $event->getName();
            }
        }

        $view = new TaskWizardReviewView($this->wizard, $event);
        echo $view->render();
    }

    public function wizardComplete()
    {
        $this->checkAdminAccess();
        $task = $this->wizard->getTask();
        if ($task->save()) {
            $_SESSION['success'] = "Task created successfully";
            $this->wizard->reset();
            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/tasks');
            exit;
        }

        $_SESSION['error'] = "Failed to create task";
        header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/tasks/wizard/review');
        exit;
    }

    public function edit($id)
    {
        $this->checkAdminAccess();
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
        $this->checkAdminAccess();
        if (isset($data['Id'])) {
            $task = Task::findById($data['Id']);
            if ($task) {
                $command = new TaskDetailsCommand($task, [
                    'name' => $data['Name'],
                    'description' => $data['Description'],
                    'hoursOfWork' => $data['HoursOfWork'],
                    'skills' => $data['skills']
                ]);

                if ($command->execute()) {
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
        $this->checkAdminAccess();
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
        $this->checkAdminAccess();
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
        $this->checkAdminAccess();
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

    public function cancelWizard()
    {
        // Reset the wizard state
        $this->wizard->reset();

        // Clear any session data related to the task
        if (isset($_SESSION['task_wizard'])) {
            unset($_SESSION['task_wizard']);
        }

        $_SESSION['info'] = "Task creation cancelled";
        header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/tasks');
        exit;
    }

    public function unassign($taskId)
    {
        $this->checkAdminAccess();
        $task = Task::findById($taskId);

        if (!$task) {
            $_SESSION['error'] = "Task not found";
            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/tasks');
            exit;
        }

        try {
            // Create command with current volunteer ID
            $command = new AssignVolunteerCommand($task, $task->getVolunteerId());
            if ($command->undo()) {
                $_SESSION['success'] = "Volunteer unassigned successfully";
            } else {
                $_SESSION['error'] = "Failed to unassign volunteer";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/tasks');
        exit;
    }
}
