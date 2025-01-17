<?php

class SocialWorker extends User{
    private $Availability;
    private $Shelter;

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $Availability, $Shelter)
    {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference);
        $this->Availability = $Availability;
        $this->Shelter = $Shelter; // Pass an instance of Shelter
    }

    public function setAvailability($Availability){
        $this->Availability = $Availability;
    }
    public function setShelter($Shelter){
        $this->Shelter = $Shelter;
    }

    public function getAvailability(){
        return $this->Availability;
    }
    public function getShelter(){
        return $this->Shelter;
    }

    public function RegisterEvent()
    {
        // to be implemented
    }
    public function Update($message)
    {
        // to be implemented
    }

    public static function findById($id){
        $db=DbConnection::getInstance();
        $sql = "SELECT 
                u.Id AS Id,
                u.Name AS Name,
                u.Age AS Age,
                u.Gender AS Gender,
                u.Address AS Address,
                u.Phone AS Phone,
                u.Nationality AS Nationality,
                u.Type AS Type,
                u.Email AS Email,
                u.Preference AS Preference,
                s.Availability AS Availability,
                s.Shelter AS Shelter
                FROM User u
                JOIN SocialWorker s ON u.Id = s.Id
                WHERE u.id = $id;";
        $rows=$db->fetchAll($sql);
        foreach($rows as $SocialWorker){
            return new self(
                $SocialWorker["Id"],
                $SocialWorker["Name"],
                $SocialWorker["Age"],
                $SocialWorker["Gender"],
                $SocialWorker["Address"],
                $SocialWorker["Phone"],
                $SocialWorker["Nationality"],
                $SocialWorker["Type"],
                $SocialWorker["Email"],
                $SocialWorker["Preference"],
                $SocialWorker["Availability"],
                $SocialWorker["Shelter"]
            );
        }
    }

    public static function all(){
        $db=DbConnection::getInstance();
        $sql = "SELECT 
                u.Id AS Id,
                u.Name AS Name,
                u.Age AS Age,
                u.Gender AS Gender,
                u.Address AS Address,
                u.Phone AS Phone,
                u.Nationality AS Nationality,
                u.Type AS Type,
                u.Email AS Email,
                u.Preference AS Preference,
                s.Availability AS Availability,
                s.Shelter AS Shelter
                FROM User u
                JOIN SocialWorker s ON u.Id = s.Id 
                WHERE u.Type = 3 AND u.IsDeleted = 0;";
        $rows=$db->fetchAll($sql);
        $SocialWorkers = [];
        foreach($rows as $SocialWorker){
            $SocialWorkers[]= new self(
                $SocialWorker["Id"],
                $SocialWorker["Name"],
                $SocialWorker["Age"],
                $SocialWorker["Gender"],
                $SocialWorker["Address"],
                $SocialWorker["Phone"],
                $SocialWorker["Nationality"],
                $SocialWorker["Type"],
                $SocialWorker["Email"],
                $SocialWorker["Preference"],
                $SocialWorker["Availability"],
                $SocialWorker["Shelter"]
            );
        }
        return $SocialWorkers ?? [];

    }

    public function save(){
        $db=DbConnection::getInstance();
        $sql = "
        INSERT INTO User (Name, Age, Gender, Address, Phone, Nationality, Type, Email, Preference)
        VALUES ('$this->Name', $this->Age, $this->Gender, $this->Address, '$this->Phone', '$this->Nationality', $this->Type, '$this->Email', $this->Preference)
        ";
        $db->query($sql);
        $sql ="SELECT LAST_INSERT_ID() AS last;";
        $rows=$db->fetchAll($sql);
        foreach($rows as $row){
            $this->Id=$row['last'];
            break;
        }
        $sql2 = "
        INSERT INTO SocialWorker (Id, Availability, Shelter)
        VALUES ($this->Id , $this->Availability, $this->Shelter)
        ";
        $db->query($sql2);
    }

    public static function editById($id,$SocialWorker){
        $db=DbConnection::getInstance();
        $sql1= "UPDATE User
        SET 
        Name = '$SocialWorker->Name',
        Age = $SocialWorker->Age,
        Gender = $SocialWorker->Gender,
        Address = $SocialWorker->Address,
        Phone = '$SocialWorker->Phone',
        Nationality = '$SocialWorker->Nationality',
        Type = $SocialWorker->Type,
        Email = '$SocialWorker->Email',
        Preference = $SocialWorker->Preference
        WHERE Id = $id;";
        $db->query($sql1);
        $sql2 = "UPDATE SocialWorker
        SET
        Availability = $SocialWorker->Availability,
        Shelter = $SocialWorker->Shelter
        WHERE Id = $id;";
         $db->query($sql2);
    }

    public Static function deleteById($id){
        $db = DbConnection::getInstance();
        $sql = "UPDATE User
        SET
        IsDeleted = 1
        WHERE Id = $id;";
        $db->query($sql);
    }
}

