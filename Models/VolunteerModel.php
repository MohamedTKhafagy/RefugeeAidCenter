<?php
require_once 'UserModel.php';
require_once 'DBInit.php';

class Volunteer extends User
{
    private $Skills;
    private $Availability;

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $Skills, $Availability)
    {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference);
        $this->Skills = $Skills;
        $this->Availability = $Availability;
    }

    public function RegisterEvent()
    {
        echo "Volunteer has registered for an event.";
    }

    public function Update($message)
    {
        echo "Updating volunteer information.";
    }

    // Getter for Skills
    public function getSkills()
    {
        return $this->Skills;
    }

    // Getter for Availability
    public function getAvailability()
    {
        return $this->Availability;
    }

    public static function findById($id)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT u.*, v.Skills, v.Availability 
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
                $volunteer["Preference"],
                $volunteer["Skills"],
                $volunteer["Availability"]
            );
        }
        return null;
    }

    public static function all()
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT u.*, v.Skills, v.Availability 
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
                $volunteer["Skills"],
                $volunteer["Availability"]
            );
        }
        return $volunteers ?? [];
    }

    public function save()
    {
        $db = DbConnection::getInstance();
        // $db->beginTransaction();
        try {
            $sql = "
            INSERT INTO User (Name, Age, Gender, Address, Phone, Nationality, Type, Email, Preference)
            VALUES ('$this->Name', $this->Age, '$this->Gender', '$this->Address', '$this->Phone', '$this->Nationality', $this->Type, '$this->Email', '$this->Preference')
            ";
            $db->query($sql);

            $sql = "SELECT LAST_INSERT_ID() AS last;";
            $rows = $db->fetchAll($sql);
            foreach ($rows as $row) {
                $userId = $row["last"];
            }

            $sql = "
            INSERT INTO Volunteer (VolunteerId, Skills, Availability)
            VALUES ($userId, '$this->Skills', '$this->Availability')
            ";
            $db->query($sql);

            return $this->findById($userId);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function editById($id, $volunteer)
    {
        $db = DbConnection::getInstance();
        // $db->beginTransaction();
        try {
            $sql = "UPDATE User
            SET 
            Name = '$volunteer->Name',
            Age = $volunteer->Age,
            Gender = '$volunteer->Gender',
            Address = '$volunteer->Address',
            Phone = '$volunteer->Phone',
            Nationality = '$volunteer->Nationality',
            Type = $volunteer->Type,
            Email = '$volunteer->Email',
            Preference = '$volunteer->Preference'
            WHERE Id = $id;";
            $db->query($sql);

            $sql = "UPDATE Volunteer
            SET 
            Skills = '$volunteer->Skills',
            Availability = '$volunteer->Availability'
            WHERE VolunteerId = $id;";
            $db->query($sql);
        } catch (Exception $e) {

            throw $e;
        }
    }

    public static function deleteById($id)
    {
        $db = DbConnection::getInstance();
        $sql = "UPDATE User
        SET
        IsDeleted = 1
        WHERE Id = $id;";
        $db->query($sql);
    }
}
?>