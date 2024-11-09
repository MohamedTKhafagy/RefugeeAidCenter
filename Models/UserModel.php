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



    public function getId()
    {
        return $this->Id;
    }

    public function setId($Id)
    {
        $this->Id = $Id;
    }

    public function getName()
    {
        return $this->Name;
    }

    public function setName($Name)
    {
        $this->Name = $Name;
    }

    public function getAge()
    {
        return $this->Age;
    }

    public function setAge($Age)
    {
        $this->Age = $Age;
    }

    public function getGender()
    {
        return $this->Gender;
    }

    public function setGender($Gender)
    {
        $this->Gender = $Gender;
    }

    public function getAddress()
    {
        return $this->Address;
    }

    public function setAddress($Address)
    {
        $this->Address = $Address;
    }

    public function getPhone()
    {
        return $this->Phone;
    }

    public function setPhone($Phone)
    {
        $this->Phone = $Phone;
    }

    public function getNationality()
    {
        return $this->Nationality;
    }

    public function setNationality($Nationality)
    {
        $this->Nationality = $Nationality;
    }

    public function getType()
    {
        return $this->Type;
    }

    public function setType($Type)
    {
        $this->Type = $Type;
    }

    public function getEmail()
    {
        return $this->Email;
    }

    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

    public function getPreference()
    {
        return $this->Preference;
    }

    public function setPreference($Preference)
    {
        $this->Preference = $Preference;
    }

    // Method to display a brief user information
    public function displayInfo()
    {
        return "Name: $this->Name, Age: $this->Age, Gender: $this->Gender, Nationality: $this->Nationality, Email: $this->Email";
    }
}
