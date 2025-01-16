<?php
require_once 'DBInit.php';

class Skill
{
    private $id;
    private $name;
    private $category;
    private $description;
    private $createdAt;

    public function __construct(
        $name,
        $category,
        $description = null,
        $id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->description = $description;
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
    public function getCategory()
    {
        return $this->category;
    }
    public function getDescription()
    {
        return $this->description;
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
    public function setCategory($category)
    {
        $this->category = $category;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function save()
    {
        $db = DbConnection::getInstance();
        if ($this->id === null) {
            // Insert new skill
            $sql = "INSERT INTO Skills (name, category, description, created_at) 
                    VALUES ('$this->name', '$this->category', " .
                ($this->description ? "'$this->description'" : "NULL") .
                ", '$this->createdAt')";
            $result = $db->query($sql);
            $sql = "SELECT LAST_INSERT_ID() as id";
            $lastId = $db->fetchAll($sql);
            $this->id = $lastId[0]['id'];
            return $result;
        } else {
            // Update existing skill
            $sql = "UPDATE Skills 
                    SET name = '$this->name', 
                        category = '$this->category', 
                        description = " . ($this->description ? "'$this->description'" : "NULL") . " 
                    WHERE id = $this->id";
            return $db->query($sql);
        }
    }

    public static function findById($id)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Skills WHERE id = $id";
        $result = $db->fetchAll($sql);

        if (empty($result)) {
            return null;
        }

        $skill = $result[0];
        return new self(
            $skill['name'],
            $skill['category'],
            $skill['description'],
            $skill['id']
        );
    }

    public static function findByName($name)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Skills WHERE name = '$name'";
        $result = $db->fetchAll($sql);

        if (empty($result)) {
            return null;
        }

        $skill = $result[0];
        return new self(
            $skill['name'],
            $skill['category'],
            $skill['description'],
            $skill['id']
        );
    }

    public static function all()
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Skills ORDER BY category, name";
        $results = $db->fetchAll($sql);

        $skills = [];
        foreach ($results as $skill) {
            $skills[] = new self(
                $skill['name'],
                $skill['category'],
                $skill['description'],
                $skill['id']
            );
        }
        return $skills;
    }

    public static function findByCategory($category)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Skills WHERE category = '$category' ORDER BY name";
        $results = $db->fetchAll($sql);

        $skills = [];
        foreach ($results as $skill) {
            $skills[] = new self(
                $skill['name'],
                $skill['category'],
                $skill['description'],
                $skill['id']
            );
        }
        return $skills;
    }

    public function getTasksWithSkill()
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT t.* FROM Tasks t 
                JOIN Task_Skills ts ON t.id = ts.task_id 
                WHERE ts.skill_id = $this->id AND t.is_deleted = 0";
        return $db->fetchAll($sql);
    }

    public function getVolunteersWithSkill()
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT v.*, vs.proficiency_level FROM Volunteer v 
                JOIN Volunteer_Skills vs ON v.VolunteerId = vs.volunteer_id 
                WHERE vs.skill_id = $this->id";
        return $db->fetchAll($sql);
    }
}
