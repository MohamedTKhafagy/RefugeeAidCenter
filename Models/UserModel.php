<?php
require_once "SingletonDB.php";
require_once "Observer.php";
require_once __DIR__ . "/../SingletonDB.php";

abstract class User  implements Observer
{

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
    abstract public function Update($Message);



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

    public function getUserId()
    {
        return $this->Id;
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
    public function getFullAddress(){
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
    private function getFullAddressHelper($address){
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Address WHERE Id = $address;";
        $rows=$db->fetchAll($sql);
        foreach($rows as $Address){
            if($Address['ParentId'] == null){
                return $Address['Name'] . ".";
            }
            return $Address['Name'] . ", " . self::getFullAddressHelper($Address['ParentId']);
        }
    }
    public function save() {
        echo $this->Age;
        $db = DbConnection::getInstance();
        $query = "INSERT INTO User (Name, Age, Gender, Address, Phone, Nationality, Type, Email, Preference) VALUES ('$this->Name', '$this->Age', '$this->Gender', '1', '$this->Phone', '$this->Nationality', '$this->Type', '$this->Email', '$this->Preference')";
        $db->query($query);
        $sql ="SELECT LAST_INSERT_ID() AS last;";
        $rows=$db->fetchAll($sql);
        foreach($rows as $row){
            echo $row["last"];
            return $row["last"];
        }
        return -1;
    }

    public static function getBy($field, $value) {
        $db = DbConnection::getInstance();
        if($field == "email") $value = $db->escape($value);
        $row = $db->getBy("User", $field, $value);
        return $row;
    }

    public static function login($data) {
        $exist = DB::findBy("/data/users.txt", "Email", $data['email']);
        if($exist) return true;
        return false;
    }
    public function editUser($data){
        $this->Name = $data['name'];
        $this->Age = $data['age'];
        $this->Gender = $data['gender'];
        $this->Address = $data['address'];
        $this->Phone = $data['phone'];
        $this->Nationality = $data['nationality'];
        $this->Type = $data['type'];
        $this->Email = $data['email'];
        $this->Preference = $data['preference'];
        $db = DbConnection::getInstance();
        $query = "UPDATE User SET Name = '$this->Name', Age = $this->Age, Gender = $this->Gender, Address = $this->Address, Phone = '$this->Phone', Nationality = '$this->Nationality', Type = $this->Type, Email = '$this->Email', Preference = $this->Preference WHERE Id = $this->Id;";
        if($db->query($query)) return true;
        return false;
        
    }
}
