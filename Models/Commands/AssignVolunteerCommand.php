<?php
require_once __DIR__ . '/TaskCommand.php';
require_once __DIR__ . '/../../Models/Task.php';
require_once __DIR__ . '/../../Models/VolunteerModel.php';

class AssignVolunteerCommand implements TaskCommand
{
    private $task;
    private $oldVolunteerId;
    private $newVolunteerId;
    private $volunteer;

    public function __construct(Task $task, $volunteerId)
    {
        if (!$task->getId()) {
            throw new Exception("Task must be saved before it can be assigned to a volunteer");
        }

        $this->task = $task;
        $this->oldVolunteerId = $task->getVolunteerId();
        $this->newVolunteerId = $volunteerId;

        // Verify volunteer exists if not null
        if ($volunteerId !== null) {
            $db = DbConnection::getInstance();
            $sql = "SELECT * FROM User WHERE Id = ? AND IsDeleted = 0";
            $result = $db->fetchAll($sql, [$volunteerId]);
            if (empty($result)) {
                throw new Exception("Volunteer with ID $volunteerId not found");
            }
        }
    }

    public function execute()
    {
        $db = DbConnection::getInstance();
        $taskId = $this->task->getId();

        if (!$taskId) {
            throw new Exception("Cannot assign volunteer: Task ID is missing");
        }

        // Update task with new volunteer ID and set status to in_progress if assigning
        $status = $this->newVolunteerId ? 'in_progress' : 'pending';
        $volunteerId = $this->newVolunteerId ? $this->newVolunteerId : null;

        $sql = "UPDATE Tasks 
                SET volunteer_id = ?, 
                    status = ? 
                WHERE id = ? 
                AND is_deleted = 0";

        $result = $db->query($sql, [$volunteerId, $status, $taskId]);
        if ($result) {
            $this->task->setVolunteerId($volunteerId);
            $this->task->setStatus($status);
        }
        return $result;
    }

    public function undo()
    {
        $db = DbConnection::getInstance();
        $taskId = $this->task->getId();

        if (!$taskId) {
            throw new Exception("Cannot undo volunteer assignment: Task ID is missing");
        }

        // When undoing, we always want to remove the volunteer assignment
        $status = 'pending';
        $volunteerId = null;

        $sql = "UPDATE Tasks 
                SET volunteer_id = ?, 
                    status = ? 
                WHERE id = ? 
                AND is_deleted = 0";

        $result = $db->query($sql, [$volunteerId, $status, $taskId]);
        if ($result) {
            $this->task->setVolunteerId($volunteerId);
            $this->task->setStatus($status);
        }
        return $result;
    }
}
