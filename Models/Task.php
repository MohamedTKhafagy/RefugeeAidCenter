<?php
require_once 'DBInit.php';
require_once 'States/TaskStates.php';
require_once 'States/PendingState.php';

class Task
{
    private $id;
    private $name;
    private $description;
    private $hoursOfWork;
    private $status;
    private $eventId;
    private $volunteerId;
    private $createdAt;
    private $currentState;
    private $skills = [];

    public function __construct(
        $name,
        $description,
        $hoursOfWork,
        $status = 'pending',
        $eventId = null,
        $volunteerId = null,
        $id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->hoursOfWork = $hoursOfWork;
        $this->status = $status;
        $this->eventId = $eventId;
        $this->volunteerId = $volunteerId;
        $this->createdAt = date('Y-m-d H:i:s');
        $this->currentState = new PendingState();
        if ($id) {
            $this->loadSkills();
        }
    }

    private function loadSkills()
    {
        if (!$this->id) return;

        $db = DbConnection::getInstance();
        $sql = "SELECT s.* FROM Skills s 
                JOIN Task_Skills ts ON s.id = ts.skill_id 
                WHERE ts.task_id = $this->id";
        $this->skills = $db->fetchAll($sql);
    }

    public function addSkill($skillId)
    {
        if (!$this->id) {
            throw new Exception("Task must be saved before adding skills");
        }

        $db = DbConnection::getInstance();
        $sql = "INSERT IGNORE INTO Task_Skills (task_id, skill_id) VALUES ($this->id, $skillId)";
        $db->query($sql);
        $this->loadSkills();
    }

    public function removeSkill($skillId)
    {
        if (!$this->id) return;

        $db = DbConnection::getInstance();
        $sql = "DELETE FROM Task_Skills WHERE task_id = $this->id AND skill_id = $skillId";
        $db->query($sql);
        $this->loadSkills();
    }

    public function getSkills()
    {
        return $this->skills;
    }

    // State pattern methods
    public function setState(TaskStates $state): void
    {
        $this->currentState = $state;
    }

    public function nextState(): void
    {
        $this->currentState->nextState($this);
    }

    public function previousState(): void
    {
        $this->currentState->previousState($this);
    }

    public function getCurrentState(): string
    {
        return $this->currentState->getCurrentState();
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getHoursOfWork()
    {
        return $this->hoursOfWork;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getEventId()
    {
        return $this->eventId;
    }

    public function getVolunteerId()
    {
        return $this->volunteerId;
    }

    // Setters
    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setHoursOfWork($hours)
    {
        $this->hoursOfWork = $hours;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
    }

    public function setVolunteerId($volunteerId)
    {
        $this->volunteerId = $volunteerId;
    }

    public function save()
    {
        $db = DbConnection::getInstance();
        if ($this->id === null) {
            // Insert new task
            $sql = "INSERT INTO Tasks (name, description, hours_of_work, status, event_id, volunteer_id, created_at) 
                    VALUES ('$this->name', '$this->description', $this->hoursOfWork, 
                            '$this->status', " . ($this->eventId ? $this->eventId : "NULL") . ", 
                            " . ($this->volunteerId ? $this->volunteerId : "NULL") . ", 
                            '$this->createdAt')";
            $result = $db->query($sql);
            $sql = "SELECT LAST_INSERT_ID() as id";
            $lastId = $db->fetchAll($sql);
            $this->id = $lastId[0]['id'];
            return $result;
        } else {
            // Update existing task
            $sql = "UPDATE Tasks 
                    SET name = '$this->name', 
                        description = '$this->description', 
                        hours_of_work = $this->hoursOfWork, 
                        status = '$this->status', 
                        event_id = " . ($this->eventId ? $this->eventId : "NULL") . ", 
                        volunteer_id = " . ($this->volunteerId ? $this->volunteerId : "NULL") . " 
                    WHERE id = $this->id AND is_deleted = 0";
            return $db->query($sql);
        }
    }

    public static function findById($id)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Tasks WHERE id = $id AND is_deleted = 0";
        $result = $db->fetchAll($sql);

        if (empty($result)) {
            return null;
        }

        $task = $result[0];
        return new self(
            $task['id'],
            $task['name'],
            $task['description'],
            $task['hours_of_work'],
            $task['status'],
            $task['event_id'],
            $task['volunteer_id']
        );
    }
}
