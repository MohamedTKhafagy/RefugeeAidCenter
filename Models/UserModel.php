<?php
require_once "SingletonDB.php";
require_once __DIR__ . '/../Proxy/UserData.php';

use RefugeeAidCenter\Proxy\UserData;

abstract class User implements UserData
{
    private static $Addressfile = __DIR__ . '/../data/Addresses.txt'; // Path to Addresses text file

    // User properties
    protected $Id;
    // Database connection instance
    protected static $db;
    // Database implementation object
    protected $userDataImpl;

    // Constants for user operations
    const OP_CREATE = 'create';
    const OP_READ = 'read';
    const OP_UPDATE = 'update';
    const OP_DELETE = 'delete';

    protected $Name;
    protected $Age;
    protected $Gender; // 0 Male 1 Female
    protected $Address;
    protected $Phone;    protected $Nationality;
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
    }*/
    public function __construct()
    {
        self::$db = DbConnection::getInstance();
    }

    public function getUserDetails(int $UserId): ?array
    {
        $sql = "SELECT * FROM users WHERE id = $UserId";
        $result = self::$db->fetchAll($sql);
        return $result ? $result[0] : null;
    }

    public function getAllUsers(): array
    {
        $sql = "SELECT * FROM users";
        return self::$db->fetchAll($sql);
    }

    public function updateUserDetails(int $UserId, array $data): bool
    {
        $name = $data['name'];
        $age = $data['age'];
        $gender = $data['gender'];
        $address = $data['address'];
        $phone = $data['phone'];
        $sql = "UPDATE users SET name = '$name', age = $age, gender = $gender, address = '$address', phone = '$phone' WHERE id = $UserId";
        return self::$db->query($sql);
    }

    public function addUser(array $data): int|false
    {
        $name = $data['name'];
        $age = $data['age'];
        $gender = $data['gender'];
        $address = $data['address'];
        $phone = $data['phone'];
        $sql = "INSERT INTO users (name, age, gender, address, phone) VALUES ('$name', $age, $gender, '$address', '$phone')";
        return self::$db->query($sql) ? self::$db->database_connection->insert_id : false;
    }

    public function deleteUser(int $UserId): bool
    {
        $sql = "DELETE FROM users WHERE id = $UserId";
        return self::$db->query($sql);
    }

    public function hasPermission(string $operation): bool
    {
        // Implement permission logic here
        return true;
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
}
