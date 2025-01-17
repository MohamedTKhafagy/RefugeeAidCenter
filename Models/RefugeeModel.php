<?php
require_once 'UserModel.php';
require_once __DIR__ . '/../SingletonDB.php';
require_once __DIR__ . '/UserCollection.php';

class Refugee extends User
{


    protected $RefugeeID;
    protected $PassportNumber;
    private $Profession;
    private $Education;


    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Password, $Preference, $PassportNumber, $Profession, $Education, $RefugeeID = null)
    {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Password, $Preference);
        $this->PassportNumber = $PassportNumber;
        $this->Profession = $Profession;
        $this->Education = $Education;
        $this->RefugeeID = $RefugeeID;
    }



    public function RegisterEvent()
    {
        echo "An event has been registered by the Refugee user.";
    }

    public function save()
    {
        $userId = parent::save();
        if ($userId == -1) return -1;
        $db = DbConnection::getInstance();
        $query = "INSERT INTO Refugee (PassportNumber, Profession, Education, UserId) VALUES ('$this->PassportNumber', '$this->Profession', '$this->Education', $userId)";
        $db->query($query);
        $sql = "SELECT LAST_INSERT_ID() AS last;";
        $rows = $db->fetchAll($sql);
        foreach ($rows as $row) {
            $this->RefugeeID = $row["last"];
            return $row["last"];
        }
        return -1;
    }

    public static function findById($id)
    {
        $db = DbConnection::getInstance();

        $query = "
        SELECT 
            User.Id AS UserId, User.Name, User.Age, User.Gender, User.Address, 
            User.Phone, User.Nationality, User.Type, User.Email, User.Preference,
            Refugee.Id AS RefugeeId, Refugee.PassportNumber, Refugee.Profession, 
            Refugee.Education
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
            $data['Profession'],
            $data['Education'],
            $id
        );

        return $refugee;
    }




    public static function all()
    {
        $db = DbConnection::getInstance();

        
        $query = "
    SELECT 
        User.Id AS UserId, User.Name, User.Age, User.Gender, User.Address, 
        User.Phone, User.Nationality, User.Type, User.Email, User.Preference,
        Refugee.Id AS RefugeeId, Refugee.PassportNumber, Refugee.Profession, 
        Refugee.Education
    FROM 
        Refugee
    INNER JOIN 
        User ON Refugee.UserId = User.Id
    WHERE
        User.IsDeleted = 0
    ";

        $rows = $db->fetchAll($query);

        $uCollection = new UserCollection();
        
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
                $data['Profession'],
                $data['Education'],
                $data['RefugeeId']
            );

            $uCollection->addUser($refugee);
        }

        return $uCollection;
    }

    public function getRefugeeID()
    {
        return $this->RefugeeID;
    }

    public function getPassportNumber()
    {
        return $this->PassportNumber;
    }

    public function getProfession()
    {
        return $this->Profession;
    }

    public function getEducation()
    {
        return $this->Education;
    }


    public function Update($data) {
        parent::Update($data);
        $this->PassportNumber = $data['passportNumber'];
        $this->Education = $data['education'];
        $this->Profession = $data['profession'];
        $db = DbConnection::getInstance();
        $sql = "UPDATE Refugee SET PassportNumber = '$this->PassportNumber', Profession = '$this->Profession', Education = '$this->Education' WHERE Id = $this->RefugeeID";
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