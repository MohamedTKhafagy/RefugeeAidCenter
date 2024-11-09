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
}
