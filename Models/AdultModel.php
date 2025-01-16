<?php

require_once 'Models/RefugeeModel.php';
require_once __DIR__ . "/../SingletonDB.php";

class Adult extends Refugee {
    private $AdultID;
    private $Profession;
    private $Education;
    private $Family = []; // Array of Refugee IDs 

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Password, $Preference, $RefugeeID, $PassportNumber, $Advisor, $Shelter, $HealthCare, $AdultID, $Profession, $Education, $Family = []) {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Password, $Preference, $RefugeeID, $PassportNumber, $Advisor, $Shelter, $HealthCare);
        $this->AdultID = $AdultID;
        $this->Profession = $Profession;
        $this->Education = $Education;
        $this->Family = $Family;
    }

    public function save() {
        $refugeeId = parent::save();
        if($refugeeId == -1) echo "Error saving refugee.";
        $db = DbConnection::getInstance();
        $query = "INSERT INTO Adult (Profession, Education, RefugeeId) VALUES ('$this->Profession', '$this->Education', $refugeeId)";
        $db->query($query);
        $sql = "SELECT LAST_INSERT_ID() AS last;";
        $rows = $db->fetchAll($sql);
        $lastId = -1;
        foreach ($rows as $row) {
            $lastId = $row["last"];
        }
        if ($lastId == -1) echo "Error saving adult.";
        else {
            $this->AdultID = $lastId;
            $this->saveFamily();
        }
    }

    private function saveFamily() {
        $db = DbConnection::getInstance();
        foreach ($this->Family as $refugeeId) {
            $query = "INSERT INTO adult_family (AdultId, FamilyId) VALUES ('$this->AdultID', '$refugeeId')";
            $db->query($query);
        }
    }

    private function getProperties($newProperty = null) {
        $properties = [
            "AdultID" => $this->AdultID,
            "Profession" => $this->Profession,
            "Education" => $this->Education,
            "Family" => $this->Family
        ];
    
        if ($newProperty) {
            $properties = array_merge($properties, $newProperty);
        }
    
        return $properties;
    }

    public function  getProfession() {
        return $this->Profession;
    }

    public function getEducation() {
        return $this->Education;
    }

    public function getFamily() {
        return $this->Family;
    }

    public function editAdult($data) {
        parent::Update($data);
        $this->Profession = $data["profession"];
        $this->Education = $data["education"];
        $this->Family = $data["family"];
        $db = DbConnection::getInstance();
        $query = "UPDATE Adult SET Profession = '$this->Profession', Education = '$this->Education' WHERE Id = '$this->AdultID'";
        if($db->query($query)) {
            $this->editFamily();
            return true;
        }
        return false;
    }

    private function editFamily() {
        $db = DbConnection::getInstance();
        $query = "DELETE FROM adult_family WHERE AdultId = '$this->AdultID'";
        $db->query($query);
        $this->saveFamily();
    }
    
}
?>
