<?php
require_once 'UserModel.php';
require_once 'DBInit.php';
require_once 'Skill.php';

class Volunteer extends User
{
    private $availability;
    private $skills = [];


    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Password, $Preference, $Skills, $Availability)
    {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Password, $Preference);
        $this->availability = $Availability;
        $this->skills = $Skills;
        if ($Id) {
            $this->loadSkills();
        }
    }

    public function addSkill($skillId)
    {
        if (!$this->Id) {
            throw new Exception("Volunteer must be saved before adding skills");
        }

        $db = DbConnection::getInstance();
        $sql = "INSERT IGNORE INTO Volunteer_Skills (volunteer_id, skill_id) 
                VALUES ($this->Id, $skillId)";
        $db->query($sql);
        $this->loadSkills();
    }

    public function removeSkill($skillId)
    {
        if (!$this->Id) return;

        $db = DbConnection::getInstance();
        $sql = "DELETE FROM Volunteer_Skills WHERE volunteer_id = $this->Id AND skill_id = $skillId";
        $db->query($sql);
        $this->loadSkills();
    }

    public function getSkills()
    {
        return $this->skills;
    }

    public function getAvailability()
    {
        $days = [];
        $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $availability = (int)$this->availability;

        for ($i = 0; $i < 7; $i++) {
            if ($availability & (1 << $i)) {
                $days[] = $dayNames[$i];
            }
        }

        return implode(', ', $days);
    }

    public function setAvailability($days)
    {
        $bits = 0;
        $dayMap = [
            'Sunday' => 0,
            'Monday' => 1,
            'Tuesday' => 2,
            'Wednesday' => 3,
            'Thursday' => 4,
            'Friday' => 5,
            'Saturday' => 6
        ];

        if (is_string($days)) {
            $days = [$days];
        }

        foreach ($days as $day) {
            if (isset($dayMap[$day])) {
                $bits |= (1 << $dayMap[$day]);
            }
        }

        $this->availability = $bits;
    }

    public function isAvailableOn($day)
    {
        $dayMap = [
            'Sunday' => 0,
            'Monday' => 1,
            'Tuesday' => 2,
            'Wednesday' => 3,
            'Thursday' => 4,
            'Friday' => 5,
            'Saturday' => 6
        ];

        if (!isset($dayMap[$day])) {
            return false;
        }

        return ($this->availability & (1 << $dayMap[$day])) !== 0;
    }

    public function RegisterEvent()
    {
        echo "Volunteer has registered for an event.";
    }



    public static function findById($id)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT u.*, v.Availability 
                FROM User u 
                JOIN Volunteer v ON u.Id = v.VolunteerId 
                WHERE u.Id = $id AND u.Type = 2 AND u.IsDeleted = 0;";
        $rows = $db->fetchAll($sql);
        foreach ($rows as $volunteer) {
            return new self(
                $volunteer["Id"],
                $volunteer["Name"],
                $volunteer["Age"],
                $volunteer["Gender"],
                $volunteer["Address"],
                $volunteer["Phone"],
                $volunteer["Nationality"],
                $volunteer["Type"],
                $volunteer["Email"],
                null,
                $volunteer["Preference"],
                null,
                $volunteer["Availability"]
            );
        }
        return null;
    }

    public static function all()
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT u.*, v.Availability 
                FROM User u 
                JOIN Volunteer v ON u.Id = v.VolunteerId 
                WHERE u.Type = 2 AND u.IsDeleted = 0;";
        $rows = $db->fetchAll($sql);
        $volunteers = [];
        foreach ($rows as $volunteer) {
            $volunteers[] = new self(
                $volunteer["Id"],
                $volunteer["Name"],
                $volunteer["Age"],
                $volunteer["Gender"],
                $volunteer["Address"],
                $volunteer["Phone"],
                $volunteer["Nationality"],
                $volunteer["Type"],
                $volunteer["Email"],
                null,
                $volunteer["Preference"],
                null,
                $volunteer["Availability"]
            );
        }
        return $volunteers ?? [];
    }

    protected function loadSkills()
    {
        if (!$this->Id) return;

        $db = DbConnection::getInstance();
        $sql = "SELECT s.id, s.name, sc.name as category 
                FROM Skills s 
                JOIN Volunteer_Skills vs ON s.id = vs.skill_id 
                JOIN SkillCategories sc ON s.category_id = sc.id
                WHERE vs.volunteer_id = ?";
        $this->skills = $db->fetchAll($sql, [$this->Id]);
    }

    public function save()
    {
        try {
            $db = DbConnection::getInstance();
            $userId = parent::save();
            if ($userId == -1) return -1;
            $sql = "INSERT INTO Volunteer (VolunteerId, Availability)
                    VALUES ($this->Id, " . $this->availability . ")
                    ON DUPLICATE KEY UPDATE Availability = " . $this->availability;
            $db->query($sql);

            foreach ($this->skills as $skillName) {
                if (empty($skillName)) continue;
                $skill = Skill::findByName($skillName);
                if (!$skill) {
                    $categoryId = Skill::getCategoryIdByName($skillName);
                    if (!$categoryId) {
                        $categoryId = Skill::getCategoryIdByName('Other');
                    }
                    $skill = new Skill($skillName, $categoryId, 'Skill for ' . $skillName);
                    $skill->save();
                }
                $this->addSkill($skill->getId());
            }

            return $this->Id;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function Update($data)
    {
        parent::Update($data);
        $db = DbConnection::getInstance();
        $av = $data['Availability'];
        $sql = "UPDATE Volunteer SET Availability = $av WHERE VolunteerId = $this->Id";
        $db->query($sql);
        if (isset($data['skills'])) {
            $db->query("DELETE FROM Volunteer_Skills WHERE volunteer_id = " . $data['Id']);
            foreach ($data['skills'] as $skillName) {
                if (empty($skillName)) continue;

                $skill = Skill::findByName($skillName);
                if (!$skill) {
                    $categoryId = Skill::getCategoryIdByName($skillName);
                    if (!$categoryId) {
                        $categoryId = Skill::getCategoryIdByName('Other');
                    }

                    $skill = new Skill($skillName, $categoryId, 'Skill for ' . $skillName);
                    $skill->save();
                }
                $this->addSkill($skill->getId());
            }
        }
    }

    public static function deleteById($id)
    {
        $db = DbConnection::getInstance();

        try {
            // Start transaction
            $db->query("START TRANSACTION");

            // Delete volunteer's skills
            $db->query("DELETE FROM Volunteer_Skills WHERE volunteer_id = ?", [$id]);

            // Mark volunteer as deleted in User table
            $db->query("UPDATE User SET IsDeleted = 1 WHERE Id = ?", [$id]);

            // Mark volunteer as deleted in Volunteer table
            $db->query("UPDATE Volunteer SET IsDeleted = 1 WHERE VolunteerId = ?", [$id]);

            // Commit transaction
            $db->query("COMMIT");
            return true;
        } catch (Exception $e) {
            // Rollback on error
            $db->query("ROLLBACK");
            throw $e;
        }
    }


    public static function emailExists($email, $excludeId = null)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT COUNT(*) as count FROM User WHERE Email = ? AND IsDeleted = 0";
        $params = [$email];

        if ($excludeId !== null) {
            $sql .= " AND Id != ?";
            $params[] = $excludeId;
        }

        $result = $db->fetchAll($sql, $params);
        return $result[0]['count'] > 0;
    }
}
