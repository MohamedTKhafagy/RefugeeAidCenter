<?php
require_once __DIR__ . '/TaskCommand.php';
require_once __DIR__ . '/../../Models/Task.php';
require_once __DIR__ . '/../../Models/Event.php';

class AssignEventCommand implements TaskCommand
{
    private $task;
    private $oldEventId;
    private $newEventId;
    private $event;

    public function __construct(Task $task, $eventId)
    {
        if (!$task->getId()) {
            throw new Exception("Task must be saved before it can be assigned to an event");
        }

        $this->task = $task;
        $this->oldEventId = $task->getEventId();
        $this->newEventId = $eventId;

        // Verify event exists
        if ($eventId !== null) {
            $this->event = Event::findById($eventId);
            if (!$this->event) {
                throw new Exception("Event with ID $eventId not found");
            }
        }
    }

    public function execute()
    {
        $db = DbConnection::getInstance();
        // If we're assigning to an event, update status to 'assigned'
        $status = $this->newEventId ? 'assigned' : 'pending';
        $eventIdValue = $this->newEventId ? $this->newEventId : "NULL";
        $taskId = $this->task->getId();

        if (!$taskId) {
            throw new Exception("Cannot assign event: Task ID is missing");
        }

        $sql = "UPDATE Tasks 
                SET event_id = $eventIdValue, 
                    status = '$status' 
                WHERE id = $taskId 
                AND is_deleted = 0";

        return $db->query($sql);
    }

    public function undo()
    {
        $db = DbConnection::getInstance();
        // If we're removing from an event, update status back to 'pending'
        $status = $this->oldEventId ? 'assigned' : 'pending';
        $eventIdValue = $this->oldEventId ? $this->oldEventId : "NULL";
        $taskId = $this->task->getId();

        if (!$taskId) {
            throw new Exception("Cannot undo event assignment: Task ID is missing");
        }

        $sql = "UPDATE Tasks 
                SET event_id = $eventIdValue, 
                    status = '$status' 
                WHERE id = $taskId 
                AND is_deleted = 0";

        return $db->query($sql);
    }
}
