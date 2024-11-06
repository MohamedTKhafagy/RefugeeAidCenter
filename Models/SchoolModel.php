<?php

class School extends Facility{
    private $SchoolID;
    private $AvailableBeds;

    public function __construct($Address,$Name,$AvailableBeds)
    {
        $this->Name = $Name;
        $this->Address = $Address;
        $this->AvailableBeds = $AvailableBeds;
    }

    public function Admit(){
        if($this->AvailableBeds>0){
            $this->AvailableBeds--;
        }
    }

    public function setName($Name){
        $this->Name = $Name;
    }
    public function setAddress($Address){
        $this->Address = $Address;
    }
    public function setAvailableBeds($AvailableBeds){
        $this->AvailableBeds = $AvailableBeds;
    }


    public function getName(){
        return $this->Name;
    }
    public function getAddress(){
        return $this->Address;
    }
    public function getAvailableBeds(){
        return $this->AvailableBeds;
    }
}