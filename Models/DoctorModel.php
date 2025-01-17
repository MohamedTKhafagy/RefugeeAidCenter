<?php

class Doctor extends User{
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
                d.Specialization AS Specialization,
                d.Availability AS Availability,
                d.Hospital AS Hospital
                FROM User u
                JOIN Doctor d ON u.Id = d.Id
                WHERE u.id = $id;";
        $rows=$db->fetchAll($sql);
        foreach($rows as $doctor){
            return new self(
                $doctor["Id"],
                $doctor["Name"],
                $doctor["Age"],
                $doctor["Gender"],
                $doctor["Address"],
                $doctor["Phone"],
                $doctor["Nationality"],
                $doctor["Type"],
                $doctor["Email"],
                $doctor["Preference"],
                $doctor["Specialization"],
                $doctor["Availability"],
                $doctor["Hospital"]
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
                d.Specialization AS Specialization,
                d.Availability AS Availability,
                d.Hospital AS Hospital
                FROM User u
                JOIN Doctor d ON u.Id = d.Id 
                WHERE u.Type = 4 AND u.IsDeleted = 0;";
        $rows=$db->fetchAll($sql);
        $doctors = [];
        foreach($rows as $doctor){
            $doctors[]= new self(
                $doctor["Id"],
                $doctor["Name"],
                $doctor["Age"],
                $doctor["Gender"],
                $doctor["Address"],
                $doctor["Phone"],
                $doctor["Nationality"],
                $doctor["Type"],
                $doctor["Email"],
                $doctor["Preference"],
                $doctor["Specialization"],
                $doctor["Availability"],
                $doctor["Hospital"]
            );
        }
        return $doctors ?? [];

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
        INSERT INTO Doctor (Id, Specialization, Availability, Hospital)
        VALUES ($this->Id ,'$this->Specialization', $this->Availability, $this->Hospital)
        ";
        $db->query($sql2);
    }

    public static function editById($id,$doctor){
        $db=DbConnection::getInstance();
        $sql1= "UPDATE User
        SET 
        Name = '$doctor->Name',
        Age = $doctor->Age,
        Gender = $doctor->Gender,
        Address = $doctor->Address,
        Phone = '$doctor->Phone',
        Nationality = '$doctor->Nationality',
        Type = $doctor->Type,
        Email = '$doctor->Email',
        Preference = $doctor->Preference
        WHERE Id = $id;";
        $db->query($sql1);
        $sql2 = "UPDATE Doctor
        SET
        Specialization = '$doctor->Specialization',
        Availability = $doctor->Availability,
        Hospital = $doctor->Hospital
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

