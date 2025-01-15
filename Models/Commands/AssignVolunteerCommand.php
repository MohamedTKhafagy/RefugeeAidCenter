<?php
require_once __DIR__ . '/TaskCommand.php';
require_once __DIR__ . '/../../Models/Task.php';

class AssignVolunteerCommand implements TaskCommand
{
    private $task;
    private $oldVolunteerId;
    private $newVolunteerId;

    public function __construct(Task $task, $volunteerId)
    {
        $this->task = $task;
        $this->oldVolunteerId = $task->getVolunteerId();
        $this->newVolunteerId = $volunteerId;
    }

    public function execute()
    {
        $this->task->setVolunteerId($this->newVolunteerId);
        return $this->task->save();
    }

    public function undo()
    {
        $this->task->setVolunteerId($this->oldVolunteerId);
        return $this->task->save();
    }
}
