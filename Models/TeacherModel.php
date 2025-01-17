<?php

class Teacher extends User{
    private $Subject;
    private $School;
    private $Availability;

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $Subject, $Availability, $School)
    {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference);
        $this->Subject = $Subject;
        $this->Availability = $Availability;
        $this->School = $School;
    }

    public function setSubject($Subject){
        $this->Subject = $Subject;
    }
    public function setAvailability($Availability){
        $this->Availability = $Availability;
    }
    public function setSchool($School){
        $this->School = $School;
    }

    public function getAvailability(){
        return $this->Availability;
    }
    public function getSubject(){
        return $this->Subject;
    }
    public function getSchool(){
        return $this->School;
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
                t.Subject AS Subject,
                t.Availability AS Availability,
                t.School AS School
                FROM User u
                JOIN Teacher t ON u.Id = t.Id
                WHERE u.id = $id;";
        $rows=$db->fetchAll($sql);
        foreach($rows as $Teacher){
            return new self(
                $Teacher["Id"],
                $Teacher["Name"],
                $Teacher["Age"],
                $Teacher["Gender"],
                $Teacher["Address"],
                $Teacher["Phone"],
                $Teacher["Nationality"],
                $Teacher["Type"],
                $Teacher["Email"],
                $Teacher["Preference"],
                $Teacher["Subject"],
                $Teacher["Availability"],
                $Teacher["School"]
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
                t.Subject AS Subject,
                t.Availability AS Availability,
                t.School AS School
                FROM User u
                JOIN Teacher t ON u.Id = t.Id 
                WHERE u.Type = 6 AND u.IsDeleted = 0;";
        $rows=$db->fetchAll($sql);
        $Teachers = [];
        foreach($rows as $teacher){
            $Teachers[]= new self(
                $teacher["Id"],
                $teacher["Name"],
                $teacher["Age"],
                $teacher["Gender"],
                $teacher["Address"],
                $teacher["Phone"],
                $teacher["Nationality"],
                $teacher["Type"],
                $teacher["Email"],
                $teacher["Preference"],
                $teacher["Subject"],
                $teacher["Availability"],
                $teacher["School"]
            );
        }
        return $Teachers ?? [];

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
        INSERT INTO Teacher (Id, Subject, Availability, School)
        VALUES ($this->Id ,'$this->School', $this->Availability, $this->School)
        ";
        $db->query($sql2);
    }

    public static function editById($id,$teacher){
        $db=DbConnection::getInstance();
        $sql1= "UPDATE User
        SET 
        Name = '$teacher->Name',
        Age = $teacher->Age,
        Gender = $teacher->Gender,
        Address = $teacher->Address,
        Phone = '$teacher->Phone',
        Nationality = '$teacher->Nationality',
        Type = $teacher->Type,
        Email = '$teacher->Email',
        Preference = $teacher->Preference
        WHERE Id = $id;";
        $db->query($sql1);
        $sql2 = "UPDATE Teacher
        SET
        Subject = '$teacher->Subject',
        Availability = $teacher->Availability,
        School = $teacher->School
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

