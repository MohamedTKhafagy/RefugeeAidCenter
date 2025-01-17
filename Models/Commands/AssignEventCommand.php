<?php
require_once __DIR__ . '/TaskCommand.php';
require_once __DIR__ . '/../../Models/Task.php';
require_once __DIR__ . '/../../Event.php';
require_once __DIR__ . '/../../DBInit.php';

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

        
        if ($eventId !== null) {
            $db = DbConnection::getInstance();
            $sql = "SELECT * FROM Events WHERE id = ? AND is_deleted = 0";
            $result = $db->fetchAll($sql, [$eventId]);

            if (empty($result)) {
                throw new Exception("Event with ID $eventId not found");
            }

            $this->event = new Event(
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
        }
    }

    public function execute()
    {
        $db = DbConnection::getInstance();
        
        $status = $this->newEventId ? 'assigned' : 'pending';
        $taskId = $this->task->getId();

        if (!$taskId) {
            throw new Exception("Cannot assign event: Task ID is missing");
        }

        $sql = "UPDATE Tasks 
                SET event_id = ?, 
                    status = ? 
                WHERE id = ? 
                AND is_deleted = 0";

        $result = $db->query($sql, [
            $this->newEventId,
            $status,
            $taskId
        ]);

        if ($result) {
            
            $this->task->setEventId($this->newEventId);
        }

        return $result;
    }

    public function undo()
    {
        $db = DbConnection::getInstance();
        
        $status = $this->oldEventId ? 'assigned' : 'pending';
        $taskId = $this->task->getId();

        if (!$taskId) {
            throw new Exception("Cannot undo event assignment: Task ID is missing");
        }

        $sql = "UPDATE Tasks 
                SET event_id = ?, 
                    status = ? 
                WHERE id = ? 
                AND is_deleted = 0";

        $result = $db->query($sql, [
            $this->oldEventId,
            $status,
            $taskId
        ]);

        if ($result) {
            
            $this->task->setEventId($this->oldEventId);
        }

        return $result;
    }
}
