<?php
require_once 'DBInit.php';

class Skill
{
    private $id;
    private $name;
    private $category_id;
    private $description;
    private $createdAt;
    private $categoryName; // To store the category name

    public function __construct(
        $name,
        $category_id,
        $description = null,
        $id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->category_id = $category_id;
        $this->description = $description;
        $this->createdAt = date('Y-m-d H:i:s');
        $this->loadCategoryName();
    }

    private function loadCategoryName()
    {
        if ($this->category_id) {
            $db = DbConnection::getInstance();
            $sql = "SELECT name FROM SkillCategories WHERE id = ?";
            $result = $db->fetchAll($sql, [$this->category_id]);
            if (!empty($result)) {
                $this->categoryName = $result[0]['name'];
            }
        }
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
    public function getCategoryId()
    {
        return $this->category_id;
    }
    public function getCategoryName()
    {
        return $this->categoryName;
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
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
        $this->loadCategoryName();
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function save()
    {
        try {
            $db = DbConnection::getInstance();

            if ($this->id) {
                
                $sql = "UPDATE Skills SET 
                        name = ?,
                        category_id = ?,
                        description = ?
                        WHERE id = ?";
                $db->query($sql, [
                    $this->name,
                    $this->category_id,
                    $this->description,
                    $this->id
                ]);
            } else {
                
                $sql = "INSERT INTO Skills (name, category_id, description) 
                        VALUES (?, ?, ?)";
                $db->query($sql, [
                    $this->name,
                    $this->category_id,
                    $this->description
                ]);

                
                $result = $db->fetchAll("SELECT LAST_INSERT_ID() as id");
                $this->id = $result[0]['id'];
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function findById($id)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT s.*, sc.name as category_name 
                FROM Skills s 
                JOIN SkillCategories sc ON s.category_id = sc.id 
                WHERE s.id = ?";
        $result = $db->fetchAll($sql, [$id]);

        if (empty($result)) {
            return null;
        }

        $skill = $result[0];
        return new self(
            $skill['name'],
            $skill['category_id'],
            $skill['description'],
            $skill['id']
        );
    }

    public static function findByName($name)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT s.*, sc.name as category_name 
                FROM Skills s 
                JOIN SkillCategories sc ON s.category_id = sc.id 
                WHERE s.name = ?";
        $result = $db->fetchAll($sql, [$name]);

        if (empty($result)) {
            return null;
        }

        $data = $result[0];
        return new self(
            $data['name'],
            $data['category_id'],
            $data['description'],
            $data['id']
        );
    }

    public static function all()
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT s.*, sc.name as category_name 
                FROM Skills s 
                JOIN SkillCategories sc ON s.category_id = sc.id 
                ORDER BY sc.name, s.name";
        $results = $db->fetchAll($sql);

        $skills = [];
        foreach ($results as $skill) {
            $skills[] = new self(
                $skill['name'],
                $skill['category_id'],
                $skill['description'],
                $skill['id']
            );
        }
        return $skills;
    }

    public static function findByCategory($category_id)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT s.*, sc.name as category_name 
                FROM Skills s 
                JOIN SkillCategories sc ON s.category_id = sc.id 
                WHERE s.category_id = ? 
                ORDER BY s.name";
        $results = $db->fetchAll($sql, [$category_id]);

        $skills = [];
        foreach ($results as $skill) {
            $skills[] = new self(
                $skill['name'],
                $skill['category_id'],
                $skill['description'],
                $skill['id']
            );
        }
        return $skills;
    }

    public static function getAllCategories()
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM SkillCategories ORDER BY name";
        return $db->fetchAll($sql);
    }

    public static function getCategoryIdByName($categoryName)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT id FROM SkillCategories WHERE name = ?";
        $result = $db->fetchAll($sql, [$categoryName]);
        return !empty($result) ? $result[0]['id'] : null;
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
