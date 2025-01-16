<?php
require_once 'UserModel.php';
require_once 'DBInit.php';
require_once 'Skill.php';

class Volunteer extends User
{
    private $availability;
    private $skills = [];

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $Availability)
    {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference);
        $this->availability = $Availability;
        if ($Id) {
            $this->loadSkills();
        }
    }

    private function loadSkills()
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
        return $this->availability;
    }

    public function RegisterEvent()
    {
        echo "Volunteer has registered for an event.";
    }

    public function Update($message)
    {
        echo "Updating volunteer information.";
    }

    public function save()
    {
        try {
            $db = DbConnection::getInstance();

            // First save/update the user data
            parent::save();

            if (!$this->Id) {
                $sql = "SELECT LAST_INSERT_ID() as last";
                $rows = $db->fetchAll($sql);
                foreach ($rows as $row) {
                    $this->Id = $row["last"];
                }
            }

            // Then save/update the volunteer data
            $sql = "INSERT INTO Volunteer (VolunteerId, Availability)
                    VALUES ($this->Id, '$this->availability')
                    ON DUPLICATE KEY UPDATE Availability = '$this->availability'";
            $db->query($sql);

            return $this;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function findById($id)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT u.*, v.Availability 
                FROM User u 
                JOIN Volunteer v ON u.Id = v.VolunteerId 
                WHERE u.Id = $id AND u.IsDeleted = 0";
        $result = $db->fetchAll($sql);

        if (empty($result)) {
            return null;
        }

        $data = $result[0];
        return new self(
            $data['Id'],
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            $data['Type'],
            $data['Email'],
            $data['Preference'],
            $data['Availability']
        );
    }

    public static function editById($id, $volunteer)
    {
        $db = DbConnection::getInstance();
        try {
            // Update user data
            $sql = "UPDATE User
                    SET Name = '$volunteer->Name',
                        Age = $volunteer->Age,
                        Gender = '$volunteer->Gender',
                        Address = '$volunteer->Address',
                        Phone = '$volunteer->Phone',
                        Nationality = '$volunteer->Nationality',
                        Type = $volunteer->Type,
                        Email = '$volunteer->Email',
                        Preference = '$volunteer->Preference'
                    WHERE Id = $id";
            $db->query($sql);

            // Update volunteer data
            $sql = "UPDATE Volunteer
                    SET Availability = '$volunteer->availability'
                    WHERE VolunteerId = $id";
            $db->query($sql);
        } catch (Exception $e) {
            throw $e;
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

    public static function all()
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT u.*, v.Availability 
                FROM User u 
                JOIN Volunteer v ON u.Id = v.VolunteerId 
                WHERE u.Type = 2 AND u.IsDeleted = 0
                ORDER BY u.Name";
        $results = $db->fetchAll($sql);

        $volunteers = [];
        foreach ($results as $data) {
            $volunteers[] = new self(
                $data['Id'],
                $data['Name'],
                $data['Age'],
                $data['Gender'],
                $data['Address'],
                $data['Phone'],
                $data['Nationality'],
                $data['Type'],
                $data['Email'],
                $data['Preference'],
                $data['Availability']
            );
        }
        return $volunteers;
    }
}
