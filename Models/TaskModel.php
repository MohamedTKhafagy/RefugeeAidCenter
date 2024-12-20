<?php
include_once __DIR__ . '/../SingletonDB.php';



class Task
{
    public $id;
    public $name;
    public $description;
    public $skillRequired;
    public $hoursOfWork;
    public $assignedVolunteerId;
    public $isCompleted;

    public function __construct($id, $name, $description, $skillRequired, $hoursOfWork, $assignedVolunteerId, $isCompleted) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->skillRequired = $skillRequired;
        $this->hoursOfWork = $hoursOfWork;
        $this->assignedVolunteerId = $assignedVolunteerId;
        $this->isCompleted = $isCompleted;
    }

    public function save() {
        $db = DbConnection::getInstance();
        $query = "INSERT INTO Task (Name, Description, SkillRequired, HoursOfWork, AssignedVolunteerId, IsDeleted, IsCompleted)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $db->query($query, [
            $this->name,
            $this->description,
            $this->skillRequired,
            $this->hoursOfWork,
            $this->assignedVolunteerId,
            $this->isDeleted,
            $this->isCompleted
        ]);
    }

    public static function all() {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Task WHERE isDeleted = 0";
        $rows = $db->fetchAll($sql);  
    
        $tasks = [];
        if ($rows) {
            foreach ($rows as $task) {
                
                $tasks[] = new Task(
                    $task['Id'], 
                    $task['Name'], 
                    $task['Description'], 
                    $task['SkillRequired'], 
                    $task['HoursOfWork'], 
                    $task['AssignedVolunteerId'], 
                    $task['IsCompleted'] 
                );
            }
        }
    
        return $tasks; 
    }
    
    
    
    public static function findById($id)
    {
        $db = DbConnection::getInstance();
        $result = $db->fetchAll("SELECT * FROM Task WHERE Id = ?", [$id]);
    
        if (empty($result)) {
            return null; 
        }
    
        $task = $result[0]; 
        return new self(
            $task["id"] ?? null,
            $task["name"] ?? null,
            $task["description"] ?? null,
            $task["skillRequired"] ?? null,
            $task["hoursOfWork"] ?? null,
            $task["assignedVolunteerId"] ?? null,
            $task["isCompleted"] ?? 0
        );
    }
    

    public static function editById($id, $task) {
        $db = DbConnection::getInstance();
        $query = "UPDATE Task SET 
                  Name = ?, Description = ?, SkillRequired = ?, HoursOfWork = ?, 
                  AssignedVolunteerId = ?, IsDeleted = ?, IsCompleted = ? 
                  WHERE Id = ?";
        $db->query($query, [
            $task->name,
            $task->description,
            $task->skillRequired,
            $task->hoursOfWork,
            $task->assignedVolunteerId,
            $task->isDeleted,
            $task->isCompleted,
            $id
        ]);
    }
    

    public static function deleteById($id)
    {
        $db = DbConnection::getInstance();
        $db->query("UPDATE Task SET IsDeleted = 1 WHERE Id = ?", [$id]);
    }

    public static function assignToVolunteer($taskId, $volunteerId)
    {
        $db = DbConnection::getInstance();
        $volunteer = $db->query("SELECT * FROM User WHERE Id = ? AND Type = 2", [$volunteerId])->fetch();

        if ($volunteer) {
            $db->query("UPDATE Task SET AssignedVolunteerId = ? WHERE Id = ?", [$volunteerId, $taskId]);
        } else {
            throw new Exception("Invalid Volunteer ID");
        }
    }

    public static function markAsCompleted($taskId)
    {
        $db = DbConnection::getInstance();
        $db->query("UPDATE Task SET IsCompleted = 1 WHERE Id = ?", [$taskId]);
    }
}
