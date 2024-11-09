<?php

class Shelter extends Facility{
    private $ShelterID;
    private $Supervisor;
    private $MaxCapacity;
    private $CurrentCapacity;

    public function __construct($Name,$Address,$Supervisor,$MaxCapacity,$CurrentCapacity)
    {
        $this->Name = $Name;
        $this->Address = $Address;
        $this->CurrentCapacity = $CurrentCapacity;
        $this->MaxCapacity = $MaxCapacity;
        $this->Supervisor= $Supervisor;
    }

    public function Assign(){
        if($this->CurrentCapacity<$this->MaxCapacity){
            $this->CurrentCapacity++;
        }
    }

    public function setMaxCapacity($MaxCapacity){
        $this->MaxCapacity = $MaxCapacity;
    }
    public function setSupervisor($Supervisor){
        $this->Supervisor = $Supervisor;
    }
    public function setName($Name){
        $this->Name = $Name;
    }
    public function setAddress($Address){
        $this->Address = $Address;
    }
    public function setCurrentCapacity($CurrentCapacity){
        if($CurrentCapacity>$this->MaxCapacity){
            return false;
        }
        else{
            $this->CurrentCapacity = $CurrentCapacity;
        }
    }


    public function getName(){
        return $this->Name;
    }
    public function getSupervisor(){
        return $this->Supervisor;
    }
    public function getAddress(){
        return $this->Address;
    }
    public function getCurrentCapacity(){
        return $this->CurrentCapacity;
    }
    public function getMaxCapacity(){
        return $this->MaxCapacity;
    }
}
