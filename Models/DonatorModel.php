<?php
require_once "UserModel.php";

class Donator extends User
{
    private $DonatorID;
    //Type: 0 = Money, 1 = Clothes, 2 = Food
    //DirectedTo: 0 = Hospital, 1 = School, 2 = Shelter
    //Collection: 0 = No Collection Fee, 1 = Add Collection Fee (Default)
    //Currency: 0 = EGP (Default), 1 = USD, 2 = GBP

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $DonatorID)
    {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference);
        $this->DonatorID = $DonatorID;
    }

    public function MakeDonation($Type, $Amount, $DirectedTo, $Collection = 1, $currency = 0)
    {
        $donation = new Donation($Type, $Amount, $DirectedTo, $Collection, $currency);
        $status = $donation->Donate();
        if ($status) {
            return $this->GetInvoice($donation);
        } else {
            return "Donation not successful";
        }
    }

    public function GetInvoice(Donation $Donation)
    {
        return $Donation->GenerateInvoice();
    }

    public function Update()
    {
        // Implement the Update method
    }

    public function RegisterEvent()
    {
        //to be done when events are implemented    
    }

    public function save()
    {
        $parentId = parent::save();
        if ($parentId == -1) echo "Error saving donator: Parent data not saved.";
        return DB::save($this->getProperties(["userId" => $parentId]), "/data/donators.txt", "DonatorID");
    }

    private function getProperties($newProperty = null)
    {
        $properties = [
            "DonatorID" => $this->DonatorID
        ];

        if ($newProperty) {
            $properties = array_merge($properties, $newProperty);
        }

        return $properties;
    }

}
