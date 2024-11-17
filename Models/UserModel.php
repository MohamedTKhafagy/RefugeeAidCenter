<?php
require_once "SingletonDB.php";

abstract class User
{
    // private static $Addressfile = __DIR__ . '/../data/Addresses.txt'; // Path to Addresses text file

    // User properties
    protected $Id;
    protected $Name;
    protected $Age;
    protected $Gender; // 0 Male 1 Female
    protected $Address;
    protected $Phone;
    protected $Nationality;
    protected $Type; //0: Refugee, 1: Donator, 2: Volunteer, 3: Social Worker, 4: Doctor, 5: Nurse, 6: Teacher  
    protected $Email;
    protected $Preference; // Communication Preference (SMS, Email) 0: Email, 1: SMS

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
    public function getAddress()
    {
        return $this->Address;
    }
    public function getPhone()
    {
        return $this->Phone;
    }
    public function getType()
    {
        return $this->Type;
    }
    public function getPreference()
    {
        return $this->Preference;
    }
    public function getEmail()
    {
        return $this->Email;
    }

    public function setName($Name)
    {
        $this->Name = $Name;
        return true;
    }
    public function setAge($Age)
    {
        $this->Age = $Age;
        return true;
    }
    public function setGender($Gender)
    {
        $this->Gender = $Gender;
        return true;
    }
    public function setAddress($Address)
    {
        $this->Address = $Address;
        return true;
    }
    public function setPhone($Phone)
    {
        $this->Phone = $Phone;
        return true;
    }
    public function setNationality($Nationality)
    {
        $this->Nationality = $Nationality;
        return true;
    }
    public function setType($Type)
    {
        $this->Type = $Type;
        return true;
    }
    public function setEmail($Email)
    {
        $this->Email = $Email;
        return true;
    }
    public function setPreference($Preference)
    {
        $this->Preference = $Preference;
        return true;
    }
    public function getFullAddress()
    {
        return $this->getFullAddressHelper($this->Address);
    }
    /*
    private function getFullAddressHelper($address){
        // Load the file data
        if (file_exists(self::$Addressfile)) {
            $data = json_decode(file_get_contents(self::$Addressfile), true);
            foreach ($data as $Address) {
                if ($Address['Id'] == $address) {
                    if ($Address['ParentId']==0){
                        return $Address['Name']. ".";
                    }
                    return $Address['Name'] . ", " . self::getFullAddressHelper($Address['ParentId']);
                }
            }
        }
        return "Error";
    }
    */
    private function getFullAddressHelper($address)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Address WHERE Id = $address;";
        $rows = $db->fetchAll($sql);
        foreach ($rows as $Address) {
            if ($Address['ParentId'] == null) {
                return $Address['Name'] . ".";
            }
            return $Address['Name'] . ", " . self::getFullAddressHelper($Address['ParentId']);
        }
    }
}
