<?php
require_once 'UserModel.php';
require_once __DIR__ . '/../SingletonDB.php';

class Refugee extends User
{


    protected $RefugeeID;
    protected $PassportNumber;
    protected $Advisor; // Instance of SocialWorker
    protected $Shelter; // Instance of Shelter
    protected $HealthCare; // Instance of HealthcareStrategy

    private static $file = __DIR__ . '/../data/refugees.txt'; // Path to text file

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Password, $Preference, $PassportNumber, $Advisor, $Shelter, $HealthCare, $RefugeeID = null)
    {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Password, $Preference);
        $this->PassportNumber = $PassportNumber;
        $this->Advisor = $Advisor; // Pass an instance of SocialWorker
        $this->Shelter = $Shelter; // Pass an instance of Shelter
        $this->HealthCare = $HealthCare; // Pass an instance of HealthcareStrategy
        $this->RefugeeID = $RefugeeID;
    }



    public function RegisterEvent()
    {
        echo "An event has been registered by the Refugee user.";
    }


    // Save refugee details to the text file (JSON format)
    public function save()
    {
        $userId = parent::save();
        if ($userId == -1) return -1;
        $db = DbConnection::getInstance();
        $query = "INSERT INTO Refugee (PassportNumber, Advisor, Shelter, HealthCare, UserId) VALUES ('$this->PassportNumber', 1, 1, $this->HealthCare, $userId)";
        $db->query($query);
        $sql = "SELECT LAST_INSERT_ID() AS last;";
        $rows = $db->fetchAll($sql);
        foreach ($rows as $row) {
            $this->RefugeeID = $row["last"];
            return $row["last"];
        }
        return -1;
    }

    private function getProperties($newProperty = null)
    {
        $properties = [
            "RefugeeID" => $this->RefugeeID,
            "PassportNumber" => $this->PassportNumber,
            "Advisor" => $this->Advisor,
            "Shelter" => $this->Shelter,
            "HealthCare" => $this->HealthCare
        ];

        if ($newProperty) {
            $properties = array_merge($properties, $newProperty);
        }

        return $properties;
    }

    // Find a refugee by ID from the text file
    public static function findById($id)
    {
        $db = DbConnection::getInstance();

        $query = "
        SELECT 
            User.Id AS UserId, User.Name, User.Age, User.Gender, User.Address, 
            User.Phone, User.Nationality, User.Type, User.Email, User.Preference,
            Refugee.Id AS RefugeeId, Refugee.PassportNumber, Refugee.Advisor, 
            Refugee.Shelter, Refugee.HealthCare
        FROM 
            Refugee
        INNER JOIN 
            User ON Refugee.UserId = User.Id
        WHERE 
            Refugee.Id = '$id'
    ";

        $rows = $db->fetchAll($query);

        if (empty($rows)) {
            return null;
        }

        $data = $rows[0];

        $refugee = new self(
            $data['UserId'],
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            $data['Type'],
            $data['Email'],
            null,
            $data['Preference'],
            $data['PassportNumber'],
            $data['Advisor'],
            $data['Shelter'],
            $data['HealthCare'],
            $id
        );

        return $refugee;
    }




    public static function all()
    {
        $db = DbConnection::getInstance();

        // Query to get all refugees along with their user data
        $query = "
    SELECT 
        User.Id AS UserId, User.Name, User.Age, User.Gender, User.Address, 
        User.Phone, User.Nationality, User.Type, User.Email, User.Preference,
        Refugee.Id AS RefugeeId, Refugee.PassportNumber, Refugee.Advisor, 
        Refugee.Shelter, Refugee.HealthCare
    FROM 
        Refugee
    INNER JOIN 
        User ON Refugee.UserId = User.Id
    WHERE
        User.IsDeleted = 0
    ";

        $rows = $db->fetchAll($query);

        if (empty($rows)) {
            return null;
        }

        $refugees = [];

        foreach ($rows as $data) {
            $refugee = new self(
                $data['UserId'],
                $data['Name'],
                $data['Age'],
                $data['Gender'],
                $data['Address'],
                $data['Phone'],
                $data['Nationality'],
                $data['Type'],
                $data['Email'],
                null,
                $data['Preference'],
                $data['PassportNumber'],
                $data['Advisor'],
                $data['Shelter'],
                $data['HealthCare'],
                $data['RefugeeId']
            );

            $refugees[] = $refugee;
        }

        return $refugees;
    }

    public function getRefugeeID()
    {
        return $this->RefugeeID;
    }

    public function getPassportNumber()
    {
        return $this->PassportNumber;
    }

    public function getAdvisor()
    {
        return $this->Advisor;
    }

    public function getShelter()
    {
        return $this->Shelter;
    }

    public function getHealthCare()
    {
        return $this->HealthCare;
    }

    public function Update($data) {
        parent::Update($data);
        $this->PassportNumber = $data['passportNumber'];
        $db = DbConnection::getInstance();
        $sql = "UPDATE Refugee SET PassportNumber = '$this->PassportNumber' WHERE Id = $this->RefugeeID";
        if($db->query($sql)) return true;
        return false;
    }

    public function delete() {
        $db = DbConnection::getInstance();
        $sql = "UPDATE user SET IsDeleted = 1 WHERE Id = $this->Id";
        $db->query($sql);
    }

}

?>