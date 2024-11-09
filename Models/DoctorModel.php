<?php

class Doctor extends User{
    private $DoctorID;
    private $Specialization;
    private $Availability;
    private $Shelter;

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $DoctorID, $Specialization, $Availability, $Shelter)
    {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference);
        $this->DoctorID = $DoctorID;
        $this->Specialization = $Specialization;
        $this->Availability = $Availability;
        $this->Shelter = $Shelter; // Pass an instance of Shelter
    }

    public function setDoctorID ($DoctorID){
        $this->DoctorID = $DoctorID;
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

    public function getDoctorID (){
        return $this->DoctorID;
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

