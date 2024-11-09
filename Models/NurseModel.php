<?php

class Nurse extends User{
    private $NurseID;
    private $Specialization;
    private $Availability;
    private $Shelter;

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $NurseID, $Specialization, $Availability, $Shelter)
    {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference);
        $this->NurseID = $NurseID;
        $this->Specialization = $Specialization;
        $this->Availability = $Availability;
        $this->Shelter = $Shelter; // Pass an instance of Shelter
    }

    public function setNurseID ($NurseID){
        $this->NurseID = $NurseID;
    }
    public function setSpecialization ($Specialization){
        $this->Specialization = $Specialization;
    }
    public function setAvailability($Availability){
        $this->Availability = $Availability;
    }
    public function setShelter($Shelter){
        $this->Shelter = $Shelter;
    }

    public function getNurseID (){
        return $this->NurseID;
    }
    public function getAvailability(){
        return $this->Availability;
    }
    public function getShelter(){
        return $this->Shelter;
    }
    public function getSpecialization (){
        return $this->Specialization;
    }
    
    public function RegisterEvent()
    {
        // to be implemented
    }
    public function Update()
    {
        // to be implemented
    }

}

