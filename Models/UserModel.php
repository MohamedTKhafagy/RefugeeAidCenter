<?php

abstract class User
{

    // User properties
    protected $Id;
    protected $Name;
    protected $Age;
    protected $Gender;
    protected $Address;
    protected $Phone;
    protected $Nationality;
    protected $Type; // Could be 'refugee', 'volunteer', etc.
    protected $Email;
    protected $Preference; // Some preferences specific to the user

    // Constructor to initialize user data
    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference)
    {
        $this->Id = $Id;
        $this->Name = $Name;
        $this->Age = $Age;
        $this->Gender = $Gender;
        $this->Address = $Address;
        $this->Phone = $Phone;
        $this->Nationality = $Nationality;
        $this->Type = $Type;
        $this->Email = $Email;
        $this->Preference = $Preference;
    }


    abstract public function RegisterEvent();
    abstract public function Update();



    // Method to display a brief user information
    public function displayInfo()
    {
        return "Name: $this->Name, Age: $this->Age, Gender: $this->Gender, Nationality: $this->Nationality, Email: $this->Email";
    }

    public function getName()
    {
        return $this->Name;
    }

    public function getAge()
    {
        return $this->Age;
    }

    public function getGender()
    {
        return $this->Gender;
    }

    public function getNationality()
    {
        return $this->Nationality;
    }

    public function getID()
    {
        return $this->Id;
    }
    public function getAddress(){
        return $this->Address;
    }
    public function getPhone(){
        return $this->Phone;
    }
    public function getType(){
        return $this->Type;
    }
    public function getPreference(){
        return $this->Preference;
    }
    public function getEmail(){
        return $this->Email;
    }
    
    public function setName($Name){
        $this->Name = $Name;
        return true;
    }
    public function setAge($Age){
        $this->Age = $Age;
        return true;
    }
    public function setGender($Gender){
        $this->Gender = $Gender;
        return true;
    }
    public function setAddress($Address){
        $this->Address = $Address;
        return true;
    }
    public function setPhone($Phone){
        $this->Phone = $Phone;
        return true;
    }
    public function setNationality ($Nationality){
        $this->Nationality = $Nationality;
        return true;
    }
    public function setType($Type){
        $this->Type = $Type;
        return true;
    }
    public function setEmail($Email){
        $this->Email = $Email;
        return true;
    }
    public function setPreference($Preference){
        $this->Preference = $Preference;
        return true;
    }
}
