<?php

class SocialWorker extends User{
    private $SocialWorkerID;
    private $Languages=[];
    private $Availability;
    private $Shelter;

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $SocialWorkerID, $Languages, $Availability, $Shelter)
    {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference);
        $this->SocialWorkerID = $SocialWorkerID;
        $this->Languages = $Languages;
        $this->Availability = $Availability;
        $this->Shelter = $Shelter; // Pass an instance of Shelter
    }

    public function setSocialWorkerID ($SocialWorkerID){
        $this->SocialWorkerID = $SocialWorkerID;
    }
    public function setAvailability($Availability){
        $this->Availability = $Availability;
    }
    public function setShelter($Shelter){
        $this->Shelter = $Shelter;
    }

    public function getSocialWorkerID (){
        return $this->SocialWorkerID;
    }
    public function getAvailability(){
        return $this->Availability;
    }
    public function getShelter(){
        return $this->Shelter;
    }
    public function addLanguage($Language){// Adds a Language to existing List
        array_push($this->Languages,$Language);
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

