<?php
require_once 'DBInit.php';
require_once 'Models/States/TaskStates.php';
require_once 'Models/States/TaskPendingState.php';
require_once 'Models/States/InProgressState.php';
require_once 'Models/States/TaskCompletedState.php';

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
    private $volunteerName;

    public function __construct(
        $name = '',
        $description = '',
        $hoursOfWork = 0,
        $status = 'pending',
        $eventId = null,
        $volunteerId = null,
        $id = null
    ) {
        $this->id = $id;
        $this->name = $name ?? '';
        $this->description = $description ?? '';
        $this->hoursOfWork = $hoursOfWork ?? 0;
        $this->status = $status ?? 'pending';
        $this->eventId = $eventId;
        $this->volunteerId = $volunteerId;
        $this->createdAt = date('Y-m-d H:i:s');

        
        switch ($status) {
            case 'completed':
                $this->currentState = new TaskCompletedState();
                break;
            case 'in_progress':
                $this->currentState = new InProgressState();
                break;
            default:
                $this->currentState = new TaskPendingState();
        }

        if ($id) {
            $this->loadSkills();
            if ($volunteerId) {
                $this->loadVolunteerName();
            }
        }
    }

    private function loadSkills()
    {
        if (!$this->id) return;

        $db = DbConnection::getInstance();
        $sql = "SELECT s.id, s.name FROM Skills s 
                JOIN Task_Skills ts ON s.id = ts.skill_id 
                WHERE ts.task_id = ?";
        $this->skills = $db->fetchAll($sql, [$this->id]);
    }

    private function loadVolunteerName()
    {
        if (!$this->volunteerId) return;

        $db = DbConnection::getInstance();
        $sql = "SELECT Name FROM User WHERE Id = ? AND IsDeleted = 0";
        $result = $db->fetchAll($sql, [$this->volunteerId]);
        if (!empty($result)) {
            $this->volunteerName = $result[0]['Name'];
        }
    }

    public function getVolunteerName()
    {
        return $this->volunteerName;
    }

    public function addSkill($skillId, $proficiencyLevel = null)
    {
        if (!$this->id) {
            throw new Exception("Task must be saved before adding skills");
        }

        $db = DbConnection::getInstance();
        $sql = "INSERT IGNORE INTO Task_Skills (task_id, skill_id) VALUES (?, ?)";
        $db->query($sql, [$this->id, $skillId]);
        $this->loadSkills();
    }

    public function removeSkill($skillId)
    {
        if (!$this->id) return;

        $db = DbConnection::getInstance();
        $sql = "DELETE FROM Task_Skills WHERE task_id = ? AND skill_id = ?";
        $db->query($sql, [$this->id, $skillId]);
        $this->loadSkills();
    }

    public function getSkills()
    {
        return $this->skills;
    }

    public function getSkillsRequired()
    {
        return implode(', ', array_column($this->getSkills(), 'name'));
    }

    
    public function setState(TaskStates $state): void
    {
        $this->currentState = $state;
        $this->status = $this->currentState->getCurrentState();
    }

    public function nextState(): void
    {
        $this->currentState->nextState($this);
        $this->status = $this->currentState->getCurrentState();
    }

    public function previousState(): void
    {
        $this->currentState->previousState($this);
        $this->status = $this->currentState->getCurrentState();
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

    public function setId($id)
    {
        $this->id = $id;
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
        try {
            $db = DbConnection::getInstance();
            if ($this->id) {
                
                $sql = "UPDATE Tasks SET 
                    name = ?, 
                    description = ?, 
                    hours_of_work = ?,
                    status = ?,
                    event_id = ?,
                    volunteer_id = ?
                    WHERE id = ?";
                $db->query($sql, [
                    $this->name,
                    $this->description,
                    $this->hoursOfWork,
                    $this->status,
                    $this->eventId,
                    $this->volunteerId,
                    $this->id
                ]);
                return true;
            } else {
                
                $sql = "INSERT INTO Tasks (name, description, hours_of_work, status, event_id, volunteer_id) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                $db->query($sql, [
                    $this->name,
                    $this->description,
                    $this->hoursOfWork,
                    $this->status,
                    $this->eventId,
                    $this->volunteerId
                ]);

                
                $result = $db->fetchAll("SELECT LAST_INSERT_ID() as id");
                $this->id = $result[0]['id'];
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public static function findById($id)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Tasks WHERE id = ? AND is_deleted = 0";
        $result = $db->fetchAll($sql, [$id]);

        if (empty($result)) {
            return null;
        }

        $task = $result[0];
        return new self(
            $task['name'],
            $task['description'],
            floatval($task['hours_of_work']),
            $task['status'],
            $task['event_id'],
            $task['volunteer_id'],
            $task['id']
        );
    }

    public function setSkillsRequired($skillNames)
    {
        $db = DbConnection::getInstance();
        $skillArray = array_map('trim', explode(',', $skillNames));
        foreach ($skillArray as $skillName) {
            $result = $db->fetchAll("SELECT id FROM Skills WHERE name = ?", [$skillName]);
            if (!empty($result)) {
                $this->addSkill($result[0]['id']);
            }
        }
    }
}
