<?php

class Nurse extends User{
    private $Specialization;
    private $Availability;
    private $Hospital;

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $Specialization, $Availability, $Hospital)
    {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference);
        $this->Specialization = $Specialization;
        $this->Availability = $Availability;
        $this->Hospital = $Hospital; // Pass an instance of Shelter
    }

    public function setSpecialization ($Specialization){
        $this->Specialization = $Specialization;
    }
    public function setAvailability($Availability){
        $this->Availability = $Availability;
    }
    public function setHospital($Hospital){
        $this->Hospital = $Hospital;
    }

    public function getAvailability(){
        return $this->Availability;
    }
    public function getHospital(){
        return $this->Hospital;
    }
    public function getSpecialization (){
        return $this->Specialization;
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
                n.Specialization AS Specialization,
                n.Availability AS Availability,
                n.Hospital AS Hospital
                FROM User u
                JOIN Nurse n ON u.Id = n.Id
                WHERE u.id = $id;";
        $rows=$db->fetchAll($sql);
        foreach($rows as $Nurse){
            return new self(
                $Nurse["Id"],
                $Nurse["Name"],
                $Nurse["Age"],
                $Nurse["Gender"],
                $Nurse["Address"],
                $Nurse["Phone"],
                $Nurse["Nationality"],
                $Nurse["Type"],
                $Nurse["Email"],
                $Nurse["Preference"],
                $Nurse["Specialization"],
                $Nurse["Availability"],
                $Nurse["Hospital"]
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
                n.Specialization AS Specialization,
                n.Availability AS Availability,
                n.Hospital AS Hospital
                FROM User u
                JOIN Nurse n ON u.Id = n.Id 
                WHERE u.Type = 5 AND u.IsDeleted = 0;";
        $rows=$db->fetchAll($sql);
        $Nurses = [];
        foreach($rows as $nurse){
            $Nurses[]= new self(
                $nurse["Id"],
                $nurse["Name"],
                $nurse["Age"],
                $nurse["Gender"],
                $nurse["Address"],
                $nurse["Phone"],
                $nurse["Nationality"],
                $nurse["Type"],
                $nurse["Email"],
                $nurse["Preference"],
                $nurse["Specialization"],
                $nurse["Availability"],
                $nurse["Hospital"]
            );
        }
        return $Nurses ?? [];

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
        INSERT INTO Nurse (Id, Specialization, Availability, Hospital)
        VALUES ($this->Id ,'$this->Specialization', $this->Availability, $this->Hospital)
        ";
        $db->query($sql2);
    }

    public static function editById($id,$Nurse){
        $db=DbConnection::getInstance();
        $sql1= "UPDATE User
        SET 
        Name = '$Nurse->Name',
        Age = $Nurse->Age,
        Gender = $Nurse->Gender,
        Address = $Nurse->Address,
        Phone = '$Nurse->Phone',
        Nationality = '$Nurse->Nationality',
        Type = $Nurse->Type,
        Email = '$Nurse->Email',
        Preference = $Nurse->Preference
        WHERE Id = $id;";
        $db->query($sql1);
        $sql2 = "UPDATE Nurse
        SET
        Specialization = '$Nurse->Specialization',
        Availability = $Nurse->Availability,
        Hospital = $Nurse->Hospital
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

