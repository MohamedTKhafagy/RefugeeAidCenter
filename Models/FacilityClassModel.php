<?php

abstract class Facility{
    protected $ID;
    protected $Name;
    protected $Address;
    protected $Type;//0:Shelter / 1:Hospital / 2:School
    public function __construct($ID, $Name, $Address, $Type){
        $this->ID = $ID;
        $this->Name = $Name;
        $this->Address = $Address;
        $this->Type = $Type;
    }
    public function getID(){
        return $this->ID;
    }
    public function getName(){
        return $this->Name;
    }
    public function getAddress(){
        return $this->Address;
    }
    public function getType(){
        return $this->Type;
    }
    public function setType($Type){
        $this->Type = $Type;
    }
    public function setAddress($Address){
        $this->Address = $Address;
    }
    public function setName($Name){
        $this->Name = $Name;
    }
}