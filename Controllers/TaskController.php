<?php
require_once __DIR__ . '/../Models/TaskModel.php';

class TaskController
{
    public function index()
    {
        $tasks = Task::all();

        include __DIR__ . '/../Views/TaskListView.php';
    }



    public function add($data = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task = new Task(
                null,
                $data['Name'],
                $data['Description'],
                $data['SkillRequired'],
                $data['HoursOfWork'],
                $data['AssignedVolunteerId'] ?? null,
                $data['IsCompleted'] ?? 0,
                $data['IsDeleted'] ?? 0
            );
            $task->save();
            header('Location: /tasks');
            exit;
        } else {
            include __DIR__ . '/../Views/AddTaskView.php';
        }
    }

    public function edit($id)
    {
        $task = Task::findById($id);
        if ($task) {
            include __DIR__ . '/../Views/EditTaskView.php';
        } else {
            header('Location: /tasks');
            exit;
        }
    }


    public function update($data)
    {
        if (isset($data['Id']) && !empty($data['Id'])) {
            $task = new Task(
                $data['Id'],
                $data['Name'],
                $data['Description'],
                $data['SkillRequired'],
                $data['HoursOfWork'],
                $data['AssignedVolunteerId'] ?? null,
                $data['IsCompleted'] ?? 0
            );
            Task::editById($task->id, $task);
            header('Location: /tasks');
            exit;
        } else {

            header('Location: /tasks');
            exit;
        }
    }






    public function delete($id)
    {
        Task::deleteById($id);
        header('Location: /tasks');
        exit;
    }

    public function assign($taskId, $volunteerId)
    {
        Task::assignToVolunteer($taskId, $volunteerId);
        header('Location: /tasks');
        exit;
    }

    public function complete($taskId)
    {
        Task::markAsCompleted($taskId);
        header('Location: /tasks');
        exit;
    }
}
