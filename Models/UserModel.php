<?php

require_once __DIR__ . '/../DB.php';

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
    protected $Password;

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

    public function getRefugeeName()
    {
        return $this->Name;
    }

    public function getRefugeeAge()
    {
        return $this->Age;
    }

    public function getRefugeeGender()
    {
        return $this->Gender;
    }

    public function getRefugeeNationality()
    {
        return $this->Nationality;
    }

    public function getRefugeeID()
    {
        return $this->Id;
    }

    public function save() {
        return DB::save($this->getProperties(), "/data/users.txt", "Id");
    }

    private function getProperties() {
        return [
            "Id" => $this->Id,
            "Name" => $this->Name,
            "Age" => $this->Age,
            "Gender" => $this->Gender,
            "Address" => $this->Address,
            "Phone" => $this->Phone,
            "Nationality" => $this->Nationality,
            "Type" => $this->Type,
            "Email" => $this->Email,
            "Preference" => $this->Preference
        ];
    }

    public static function login($data) {
        $exist = DB::findBy("/data/users.txt", "Email", $data['email']);
        if($exist) return true;
        return false;
    }
}
