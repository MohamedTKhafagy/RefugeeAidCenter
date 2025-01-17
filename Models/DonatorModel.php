<?php
require_once "UserModel.php";
require_once "SingletonDB.php";

class Donator extends User{

    //private static $file = __DIR__ . '/../data/donators.txt'; // Path to text file

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Password, $Preference)
    {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Password, $Preference);
    }

    //Type: 0 = Money, 1 = Clothes, 2 = Food
    //DirectedTo: 0 = Hospital, 1 = School, 2 = Shelter
    //Collection: 0 = No Collection Fee, 1 = Add Collection Fee (Default)
    //Currency: 0 = EGP (Default), 1 = USD, 2 = GBP
   /* public function MakeDonation($Type,$Amount,$DirectedTo,$Collection=1,$currency=0){
       $donation =new Donation($Type,$Amount,$DirectedTo,$Collection,$currency);
       $status = $donation->Donate();
       if($status){
        return $this->GetInvoice($donation);
       }
       else{
        return "Donation not successful";
       }
    }*/

    public function GetInvoice(Donation $Donation){
        return $Donation->GenerateInvoice();
    }

    public function RegisterEvent()
    {
        //to be done when events are implemented    
    }
    public function Update($message)
    {
        //to be implemented
    }

    public static function findById($id){
        $db=DbConnection::getInstance();
        $sql = "SELECT * FROM User WHERE Id = $id;";
        $rows=$db->fetchAll($sql);
        foreach($rows as $donor){
            return new self(
                $donor["Id"],
                $donor["Name"],
                $donor["Age"],
                $donor["Gender"],
                $donor["Address"],
                $donor["Phone"],
                $donor["Nationality"],
                $donor["Type"],
                $donor["Email"],
                null,
                $donor["Preference"]);
        }
    }

    public static function all(){
        $db=DbConnection::getInstance();
        $sql = "SELECT * FROM User WHERE Type = 1 AND IsDeleted = 0;";
        $rows=$db->fetchAll($sql);
        $donators = [];
        foreach($rows as $donor){
            $donators[]= new self(
                $donor["Id"],
                $donor["Name"],
                $donor["Age"],
                $donor["Gender"],
                $donor["Address"],
                $donor["Phone"],
                $donor["Nationality"],
                $donor["Type"],
                $donor["Email"],
                null,
                $donor["Preference"]);
        }
        return $donators ?? [];

    }

    public function save(){
        $db=DbConnection::getInstance();
        $sql = "
        INSERT INTO User (Name, Age, Gender, Address, Phone, Nationality, Type, Email, Password, Preference)
        VALUES ('$this->Name', $this->Age, $this->Gender, $this->Address, '$this->Phone', '$this->Nationality', 1, '$this->Email', '$this->Password', $this->Preference)
        ";
        $db->query($sql);
        $sql ="SELECT LAST_INSERT_ID() AS last;";
        $rows=$db->fetchAll($sql);
        foreach($rows as $row){
            $this->Id = $row["last"];
        }
        return $this->Id;
    }

    public static function editById($id,$donor){
        $db=DbConnection::getInstance();
        $sql= "UPDATE User
        SET 
        Name = '$donor->Name',
        Age = $donor->Age,
        Gender = $donor->Gender,
        Address = $donor->Address,
        Phone = '$donor->Phone',
        Nationality = '$donor->Nationality',
        Type = $donor->Type,
        Email = '$donor->Email',
        Preference = $donor->Preference
        WHERE Id = $id;";
        $db->query($sql);
    }

    public Static function deleteById($id){
        $db = DbConnection::getInstance();
        $sql = "UPDATE User
        SET
        IsDeleted = 1
        WHERE Id = $id;";
        $db->query($sql);
    }
    public static function findDonationsById($id){
        $db=DbConnection::getInstance();
        $sql = "SELECT d.*
                FROM donation d
                JOIN donatordonation dd ON d.Id = dd.DonationId
                WHERE dd.donatorId = $id;";
        $rows=$db->fetchAll($sql);
        $donations = [];
        foreach($rows as $donation){
            $donations[]= new Donation(
                $donation["Id"],
                $donation["Type"],
                $donation["Amount"],
                $donation["DirectedTo"],
                $donation["Collection"],
                $donation["Currency"],
                $donation["State"]
                );
        }
        return $donations ?? [];
    }
}



/*
    public function save()
    {
        // Load existing data
        $data = file_exists(self::$file) ? json_decode(file_get_contents(self::$file), true) : [];

        // Add this donators's data to the array
        $data[] = [
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

        // Write the updated data back to the file
        if (file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT))) {
            echo "Donator saved successfully.";
        } else {
            echo "Error saving Donator.";
        }
    }

    // Find a Donator by ID from the text file
    public static function findById($id)
    {
        // Load the file data
        if (file_exists(self::$file)) {
            $data = json_decode(file_get_contents(self::$file), true);
            // Search for the Donator by ID
            foreach ($data as $donator) {
                if ($donator['Id'] == $id) {
                    // Create a new Refugee instance with the found data
                    return new self(
                        $donator['Id'] ?? null,
                        $donator['Name'] ?? null,
                        $donator['Age'] ?? null,
                        $donator['Gender'] ?? null,
                        $donator['Address'] ?? null,
                        $donator['Phone'] ?? null,
                        $donator['Nationality'] ?? null,
                        $donator['Type'] ?? null,
                        $donator['Email'] ?? null,
                        $donator['Preference'] ?? null,
                    );
                }
            }
        }
        return null;
    }

    // Get all refugees from the text file
    public static function all()
    {
        // Load the file data
        if (file_exists(self::$file)) {
            $data = json_decode(file_get_contents(self::$file), true);

            // Create an array of Refugee instances
            $donators = [];
            foreach ($data as $donator) {
                $donators[] = new self(
                    $donator['Id'] ?? null,
                    $donator['Name'] ?? null,
                    $donator['Age'] ?? null,
                    $donator['Gender'] ?? null,
                    $donator['Address'] ?? null,
                    $donator['Phone'] ?? null,
                    $donator['Nationality'] ?? null,
                    $donator['Type'] ?? null,
                    $donator['Email'] ?? null,
                    $donator['Preference'] ?? null,
                );
            }
        }
        return $donators ?? [];
    }



    public static function getLatestId() {
    
        // Read the file content
        $fileContent = file_get_contents(self::$file);
        $data = json_decode($fileContent, true);
    
        // Check if JSON decoding was successful and if the data is an array
        if ($data === null || !is_array($data) || empty($data)) {
            return 0;
        }
    
        // Extract the IDs and find the maximum
        $ids = array_map(function($item) {
            return isset($item['Id']) ? (int)$item['Id'] : 0;
        }, $data);
    
        return !empty($ids) ? max($ids) : 0;
    }
    

    public static function editById($id, $donor)
    {
    // Load the file data
    if (file_exists(self::$file)) {
        $data = json_decode(file_get_contents(self::$file), true);
        // Loop through the data and update the user with the matching ID
        foreach ($data as &$donator) {
            if ($donator['Id'] == $id) {
                $donator['Id'] = $donor->getID();
                $donator['Name'] = $donor->getName();
                $donator['Age'] = $donor->getAge();
                $donator['Gender'] = $donor->getGender();
                $donator['Address'] = $donor->getAddress();
                $donator['Phone'] = $donor->getPhone();
                $donator['Nationality'] = $donor->getNationality();
                $donator['Type'] = $donor->getType();
                $donator['Email'] = $donor->getEmail();
                $donator['Preference'] = $donor->getPreference();
                break;
            }
        }

        // Save the updated data back to the file
        file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT));

        return true; // Indicate success
    }

        return false; // File does not exist or operation failed
    }


    public static function deleteById($id)
    {
    // Load the file data
    if (file_exists(self::$file)) {
        $data = json_decode(file_get_contents(self::$file), true);

        // Filter out the user with the matching ID
        $data = array_filter($data, function ($donator) use ($id) {
            return $donator['Id'] != $id;
        });

        // Save the updated data back to the file
        file_put_contents(self::$file, json_encode(array_values($data), JSON_PRETTY_PRINT));

        return true; // Indicate success
    }

        return false; // File does not exist or operation failed
    }
*/