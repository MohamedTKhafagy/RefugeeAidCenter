<?php
require_once __DIR__ . '/../Views/TaskListView.php';

class TaskController
{
    public function index() {
        $tasks = Task::all(); 
        include __DIR__ . '/../Views/TaskListView.php'; 
    }
    

    public function add($data = null)
    {
        if ($data) {
            $task = new Task(null, $data['Name'], $data['Description'], $data['SkillRequired'], $data['HoursOfWork']);
            $task->save();
            header('Location: /tasks');
        } else {
            require 'Views/AddTaskView.php';
        }
    }

    public function edit($id)
    {
        $task = Task::findById($id);
        require 'Views/EditTaskView.php';
    }

    public function update($data)
    {
        $task = new Task($data['Id'], $data['Name'], $data['Description'], $data['SkillRequired'], $data['HoursOfWork'], $data['AssignedVolunteerId']);
        Task::editById($data['Id'], $task);
        header('Location: /tasks');
    }

    public function delete($id)
    {
        Task::deleteById($id);
        header('Location: /tasks');
    }

    public function assign($taskId, $volunteerId)
    {
        Task::assignToVolunteer($taskId, $volunteerId);
        header('Location: /tasks');
    }

    public function complete($taskId)
    {
        Task::markAsCompleted($taskId);
        header('Location: /tasks');
    }
}
