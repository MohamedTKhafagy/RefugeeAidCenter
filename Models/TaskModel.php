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

    // Create and save a new task
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

    // Retrieve all tasks
    public static function all() {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Task WHERE isDeleted = 0";
        $rows = $db->fetchAll($sql);  // Fetch the data
    
        $tasks = [];
        if ($rows) {
            foreach ($rows as $task) {
                // Assign values correctly to Task objects
                $tasks[] = new Task(
                    $task['Id'], 
                    $task['Name'], 
                    $task['Description'], 
                    $task['SkillRequired'], 
                    $task['HoursOfWork'], 
                    $task['AssignedVolunteerId'], 
                    $task['IsCompleted'] // Make sure these are set correctly
                );
            }
        }
    
        return $tasks; // Return the populated Task objects
    }
    
    
    
    
    
    
    
    // Retrieve a task by ID
    public static function findById($id)
    {
        $db = DbConnection::getInstance();
        $result = $db->fetchAll("SELECT * FROM Task WHERE Id = ?", [$id]);
    
        if (empty($result)) {
            return null; // Return null if no task is found
        }
    
        // Assuming the result contains a single task
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
    

    // Update an existing task
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
    

    // Soft delete a task
    public static function deleteById($id)
    {
        $db = DbConnection::getInstance();
        $db->query("UPDATE Task SET IsDeleted = 1 WHERE Id = ?", [$id]);
    }

    // Assign a task to a volunteer
    public static function assignToVolunteer($taskId, $volunteerId)
    {
        // Ensure the volunteer exists and is of type 2
        $db = DbConnection::getInstance();
        $volunteer = $db->query("SELECT * FROM User WHERE Id = ? AND Type = 2", [$volunteerId])->fetch();

        if ($volunteer) {
            $db->query("UPDATE Task SET AssignedVolunteerId = ? WHERE Id = ?", [$volunteerId, $taskId]);
        } else {
            throw new Exception("Invalid Volunteer ID");
        }
    }

    // Mark task as completed
    public static function markAsCompleted($taskId)
    {
        $db = DbConnection::getInstance();
        $db->query("UPDATE Task SET IsCompleted = 1 WHERE Id = ?", [$taskId]);
    }
}
