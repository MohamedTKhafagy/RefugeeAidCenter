<?php
require_once 'DBInit.php';

class Event
{
    private $id;
    private $name;
    private $location;
    private $type;
    private $maxCapacity;
    private $currentCapacity;
    private $date;
    private $createdAt;
    private $is_deleted = 0;

    public function __construct(
        $id = null,
        $name,
        $location,
        $type,
        $maxCapacity,
        $currentCapacity,
        $date
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->location = $location;
        $this->type = $type;
        $this->maxCapacity = $maxCapacity;
        $this->currentCapacity = $currentCapacity;
        $this->date = $date;
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
    public function getLocation()
    {
        return $this->location;
    }
    public function getType()
    {
        return $this->type;
    }
    public function getMaxCapacity()
    {
        return $this->maxCapacity;
    }
    public function getCurrentCapacity()
    {
        return $this->currentCapacity;
    }
    public function getDate()
    {
        return $this->date;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    // Setters
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setLocation($location)
    {
        $this->location = $location;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function setMaxCapacity($maxCapacity)
    {
        $this->maxCapacity = $maxCapacity;
    }
    public function setCurrentCapacity($currentCapacity)
    {
        $this->currentCapacity = $currentCapacity;
    }
    public function setDate($date)
    {
        $this->date = $date;
    }

    public function save()
    {
        $db = DbConnection::getInstance();
        if ($this->id === null) {
            // Insert new event
            $sql = "INSERT INTO Events (name, location, type, max_capacity, current_capacity, date, created_at) 
                    VALUES ('$this->name', '$this->location', $this->type, $this->maxCapacity, 
                            $this->currentCapacity, '$this->date', '$this->createdAt')";
            $result = $db->query($sql);
            $sql = "SELECT LAST_INSERT_ID() as id";
            $lastId = $db->fetchAll($sql);
            $this->id = $lastId[0]['id'];
            return $result;
        } else {
            // Update existing event
            $sql = "UPDATE Events 
                    SET name = '$this->name', 
                        location = '$this->location', 
                        type = $this->type, 
                        max_capacity = $this->maxCapacity, 
                        current_capacity = $this->currentCapacity, 
                        date = '$this->date' 
                    WHERE id = $this->id AND is_deleted = 0";
            return $db->query($sql);
        }
    }

    public function delete()
    {
        if ($this->id) {
            $db = DbConnection::getInstance();
            $sql = "UPDATE Events SET is_deleted = 1 WHERE id = $this->id";
            $db->query($sql);
            $this->is_deleted = 1;
            return true;
        }
        return false;
    }

    public function getAssignedTasks()
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Tasks WHERE event_id = $this->id AND is_deleted = 0";
        return $db->fetchAll($sql);
    }

    public static function findById($id)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Events WHERE id = $id AND is_deleted = 0";
        $result = $db->fetchAll($sql);

        if (empty($result)) {
            return null;
        }

        $event = $result[0];
        return new self(
            $event['id'],
            $event['name'],
            $event['location'],
            $event['type'],
            $event['max_capacity'],
            $event['current_capacity'],
            $event['date']
        );
    }

    public static function all()
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Events WHERE is_deleted = 0 ORDER BY date DESC";
        $results = $db->fetchAll($sql);

        $events = [];
        foreach ($results as $event) {
            $events[] = new self(
                $event['id'],
                $event['name'],
                $event['location'],
                $event['type'],
                $event['max_capacity'],
                $event['current_capacity'],
                $event['date']
            );
        }
        return $events;
    }
}
