<?php
require_once __DIR__ . '/TaskCommand.php';
require_once __DIR__ . '/../../Models/Task.php';

class AssignEventCommand implements TaskCommand
{
    private $task;
    private $oldEventId;
    private $newEventId;

    public function __construct(Task $task, $eventId)
    {
        $this->task = $task;
        $this->oldEventId = $task->getEventId();
        $this->newEventId = $eventId;
    }

    public function execute()
    {
        $this->task->setEventId($this->newEventId);
        return $this->task->save();
    }

    public function undo()
    {
        $this->task->setEventId($this->oldEventId);
        return $this->task->save();
    }
}
