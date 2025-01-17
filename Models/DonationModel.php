<?php
include_once "DonationsState.php";
include_once "SingletonDB.php";
include_once "DonationStrategy.php";
include_once "MoneyDonationDecorator.php";
class Donation {
    private static $file = __DIR__ . '/../data/donations.txt'; // Path to text file
    private static $DonationToDonatorfile = __DIR__ . '/../data/DonationDonator.txt'; // Path to text file


    private $Id;
    private DonationStrategy $DonationStrategy;
    private DonationStates $state = new PendingState();
    private $Amount;
    private $Type;//Type: 0 = Money, 1 = Clothes, 2 = Food
    private $DirectedTo;//DirectedTo: 0 = Hospital, 1 = School, 2 = Shelter
    private $Collection;//Collection: 0 = No Collection Fee, 1 = Add Collection Fee (Default)
    private $currency;//Currency: 0 = EGP (Default), 1 = USD, 2 = GBP
    private $failed = false;

    public function __construct($Id,$Type,$Amount,$DirectedTo,$Collection=1,$currency=0,$state){
        $this->Id = $Id;
        $this->Type = $Type;
        $this->Amount = $Amount;
        $this->DirectedTo = $DirectedTo;
        $this->Collection = $Collection;
        $this->currency = $currency;
        $this->setState($state);
        $this->InitializeDonationStrategy();
    }

    public function NextState(){
            $this->state->nextState($this,$this->failed);
            $this->updateState();  
    }

    public function setState($state){
        if($state == "Failed"){
            $this->state = new FailedState();
        }
        else if ($state == "Pending"){
            $this->state = new PendingState();
        }
        else{
            $this->state = new CompletedState();
        }
    }
    public function getState(){
        return $this->state->getCurrentState();
    }

    public function PrevState(){
        if($this->getState()=="Failed"){
            $failed = false;
            $this->state->nextState($this,$this->failed);
            $this->updateState();
        }
        $this->state->previousState($this,$this->failed);
    }

    
    public function InitializeDonationStrategy(){
        if($this->Type == 0){//Money
            if($this->DirectedTo == 0){//Hospital
                $this->DonationStrategy = new HospitalDonation($this->Amount);
                if($this->currency == 0){
                    if($this->Collection){
                        $this->DonationStrategy = new CollectionFeeDecorator(new TaxDecorator($this->DonationStrategy));
                    }
                    else{
                        $this->DonationStrategy = new TaxDecorator($this->DonationStrategy);
                    }
                }
                elseif($this->currency == 1)
                {
                    if($this->Collection){
                        $this->DonationStrategy = new CollectionFeeDecorator(new TaxDecorator(new USDDecorator($this->DonationStrategy)));
                    }
                    else{
                        $this->DonationStrategy = new TaxDecorator(new USDDecorator($this->DonationStrategy));
                    }
                }
                elseif ($this->currency == 2){
                    if($this->Collection){
                        $this->DonationStrategy = new CollectionFeeDecorator(new TaxDecorator(new GBPDecorator($this->DonationStrategy)));
                    }
                    else{
                        $this->DonationStrategy = new TaxDecorator(new GBPDecorator($this->DonationStrategy));
                    }
                }
            }
            elseif($this->DirectedTo == 1){//School
                $this->DonationStrategy = new SchoolDonation($this->Amount);
                if($this->currency == 0){
                    if($this->Collection){
                        $this->DonationStrategy = new CollectionFeeDecorator(new TaxDecorator($this->DonationStrategy));
                    }
                    else{
                        $this->DonationStrategy = new TaxDecorator($this->DonationStrategy);
                    }
                }
                elseif($this->currency == 1)
                {
                    if($this->Collection){
                        $this->DonationStrategy = new CollectionFeeDecorator(new TaxDecorator(new USDDecorator($this->DonationStrategy)));
                    }
                    else{
                        $this->DonationStrategy = new TaxDecorator(new USDDecorator($this->DonationStrategy));
                    }
                }
                elseif ($this->currency == 2){
                    if($this->Collection){
                        $this->DonationStrategy = new CollectionFeeDecorator(new TaxDecorator(new GBPDecorator($this->DonationStrategy)));
                    }
                    else{
                        $this->DonationStrategy = new TaxDecorator(new GBPDecorator($this->DonationStrategy));
                    }
                }
            }
            elseif($this->DirectedTo == 2){//Shelter
                $this->DonationStrategy = new ShelterDonation($this->Amount);
                if($this->currency == 0){
                    if($this->Collection){
                        $this->DonationStrategy = new CollectionFeeDecorator(new TaxDecorator($this->DonationStrategy));
                    }
                    else{
                        $this->DonationStrategy = new TaxDecorator($this->DonationStrategy);
                    }
                }
                elseif($this->currency == 1)
                {
                    if($this->Collection){
                        $this->DonationStrategy = new CollectionFeeDecorator(new TaxDecorator(new USDDecorator($this->DonationStrategy)));
                    }
                    else{
                        $this->DonationStrategy = new TaxDecorator(new USDDecorator($this->DonationStrategy));
                    }
                }
                elseif ($this->currency == 2){
                    if($this->Collection){
                        $this->DonationStrategy = new CollectionFeeDecorator(new TaxDecorator(new GBPDecorator($this->DonationStrategy)));
                    }
                    else{
                        $this->DonationStrategy = new TaxDecorator(new GBPDecorator($this->DonationStrategy));
                    }
                }
            }
        }
        elseif($this->Type == 1){//Clothes
            $this->DonationStrategy = new ClothesDonation($this->Amount);
           
        }
        elseif($this->Type == 2){//Food
            $this->DonationStrategy = new FoodResourceDonation($this->Amount);
            
        }
    }


    // Setter methods
    public function setID($Id) {
        $this->Id = $Id;
    }
    public function setDonationStrategy($DonationStrategy){
        $this->DonationStrategy = $DonationStrategy;
    }
    public function setFailed($failed){
        $this->failed = $failed;
    }

    // Getter methods
    public function getID() {
        return $this->Id;
    }
    public function GenerateInvoice(){
        if($this->state->getCurrentState()=="Completed"){
            return $this->DonationStrategy->Description();
        }
        elseif($this->state->getCurrentState()=="Pending"){
            return "This Donation is pending.";
        }else{
            return "This Donation Failed";
        }
    }
    public function Donate(){
        return $this->DonationStrategy->Donate();
    }
    public function getType() {
        return $this->Type;
    }
    public function getAmount() {
        return $this->Amount;
    }
    public function getDirectedTo() {
        return $this->DirectedTo;
    }
    public function getCollection() {
        return $this->Collection;
    }
/*
    public function recordTransaction($DonatorId){
         // Load existing data
         $data = file_exists(self::$DonationToDonatorfile) ? json_decode(file_get_contents(self::$DonationToDonatorfile), true) : [];

         // Add this donators's data to the array
         $data[] = [
             "DonationId" => $this->Id,
             "DonatorId" => $DonatorId,
         ];
 
         // Write the updated data back to the file
         if (file_put_contents(self::$DonationToDonatorfile, json_encode($data, JSON_PRETTY_PRINT))) {
             echo "Transaction saved successfully.";
         } else {
             echo "Error saving Donation.";
         }
    }
         */
    public function recordTransaction($DonatorId){
        $db=DbConnection::getInstance();
        $sql = " 
       INSERT INTO `donatordonation` (`DonatorId`, `DonationId`) VALUES ('$DonatorId', '$this->Id');
        ";
        $db->query($sql);
    }
   
    public static function findById($id){
        $db=DbConnection::getInstance();
        $sql = "SELECT * FROM Donation WHERE Id = $id;";
        $rows=$db->fetchAll($sql);
        foreach($rows as $donation){
            return new self(
                $donation["Id"],
                $donation["Type"],
                $donation["Amount"],
                $donation["DirectedTo"],
                $donation["Collection"],
                $donation["Currency"],
                $donation["State"]
                );
        }
    }
    
    public static function all(){
        $db=DbConnection::getInstance();
        $sql = "SELECT * FROM Donation";
        $rows=$db->fetchAll($sql);
        $donations = [];
        foreach($rows as $donation){
            $donations[]= new self(
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
    public function updateState(){
        $db=DbConnection::getInstance();
        $state = $this->state->getCurrentState();
        $sql = "
        UPDATE Donation
        SET State = '$state'
        WHERE id = $this->Id;
        ";
        $db->query($sql);
    }
    
    public function save(){
        $db=DbConnection::getInstance();
        $state = $this->state->getCurrentState();
        $sql = "
        INSERT INTO Donation (Amount, Type, DirectedTo, Collection, Currency, State)
        VALUES ($this->Amount, $this->Type, $this->DirectedTo, $this->Collection, $this->currency, '$state')
        ";
        $db->query($sql);
        $sql ="SELECT LAST_INSERT_ID() AS last;";
        $rows=$db->fetchAll($sql);
        foreach($rows as $row){
            return $this->findById($row["last"]);
        }
    }
    public function findDonatorId(){
        $db=DbConnection::getInstance();
        $sql = "SELECT * FROM donatordonation Where DonationId = $this->Id";
        $rows=$db->fetchAll($sql);
        foreach($rows as $row){
            return $row['DonatorId'];
        }
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
            "Type" => $this->Type,
            "Amount" => $this->Amount,
            "DirectedTo" => $this->DirectedTo,
            "Collection" => $this->Collection,
            "Currency" => $this->currency
        ];

        // Write the updated data back to the file
        if (file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT))) {
            echo "Donation saved successfully.";
        } else {
            echo "Error saving Donation.";
        }
    }

    public function findDonatorId(){
         // Load the file data
         if (file_exists(self::$DonationToDonatorfile)) {
            $data = json_decode(file_get_contents(self::$DonationToDonatorfile), true);
            // Search for the Donator by ID
            foreach ($data as $donation) {
                if ($donation['DonationId'] == $this->Id) {
                    // Create a new Donation instance with the found data
                    return $donation['DonatorId'];
                }
            }
        }
        return null;
    }
    // Find a Donator by ID from the text file
    public static function findById($id)
    {
        
        // Load the file data
        if (file_exists(self::$file)) {
            $data = json_decode(file_get_contents(self::$file), true);
            // Search for the Donator by ID
            foreach ($data as $donation) {
                if ($donation['Id'] == $id) {
                    // Create a new Donation instance with the found data
                    return new self(
                        $donation['Id'] ?? null,
                        $donation['Type'] ?? null,
                        $donation['Amount'] ?? null,
                        $donation['DirectedTo'] ?? null,
                        $donation['Collection'] ?? null,
                        $donation['Currency'] ?? null
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
            $donations = [];
            foreach ($data as $donation) {
                $donations[] = new self(
                    $donation['Id'] ?? null,
                    $donation['Type'] ?? null,
                    $donation['Amount'] ?? null,
                    $donation['DirectedTo'] ?? null,
                    $donation['Collection'] ?? null,
                    $donation['Currency'] ?? null
                );
            }
        }
        return $donations ?? [];
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
    */
/*function extractLastNumber($url)
{
    // Use a regular expression to match the last number
    if (preg_match('/\d+(?=[^\/]*$)/', $url, $matches)) {
        return (int)$matches[0]; // Convert the match to an integer
    }
    return null; // Return null if no number is found
}
*/