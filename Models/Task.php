<?php
require_once 'DBInit.php';

class Task
{
    private $id;
    private $name;
    private $description;
    private $hoursOfWork;
    private $skillsRequired;
    private $status;
    private $eventId;
    private $volunteerId;
    private $createdAt;

    public function __construct(
        $id = null,
        $name,
        $description,
        $hoursOfWork,
        $skillsRequired,
        $status = 'pending',
        $eventId = null,
        $volunteerId = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->hoursOfWork = $hoursOfWork;
        $this->skillsRequired = $skillsRequired;
        $this->status = $status;
        $this->eventId = $eventId;
        $this->volunteerId = $volunteerId;
        $this->createdAt = date('Y-m-d H:i:s');
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

    public function getSkillsRequired()
    {
        return $this->skillsRequired;
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

    public function setSkillsRequired($skills)
    {
        $this->skillsRequired = $skills;
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
        $sql = "INSERT INTO Tasks (name, description, hours_of_work, skills_required, status, event_id, volunteer_id, created_at) 
                VALUES ('$this->name', '$this->description', $this->hoursOfWork, '$this->skillsRequired', 
                        '$this->status', " . ($this->eventId ? $this->eventId : "NULL") . ", 
                        " . ($this->volunteerId ? $this->volunteerId : "NULL") . ", 
                        '$this->createdAt')";

        return $db->query($sql);
    }

    public static function findById($id)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Tasks WHERE id = ? AND is_deleted = 0";
        $rows = $db->fetchAll($sql);

        if (empty($rows)) {
            return null;
        }

        $result = $rows[0];
        return new self(
            $result['id'],
            $result['name'],
            $result['description'],
            $result['hours_of_work'],
            $result['skills_required'],
            $result['status'],
            $result['event_id'],
            $result['volunteer_id']
        );
    }
}
