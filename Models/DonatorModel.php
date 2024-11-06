<?php
require_once "UserModel.php";

class Donator extends User{
    private $DonatorID;
    //Type: 0 = Money, 1 = Clothes, 2 = Food
    //DirectedTo: 0 = Hospital, 1 = School, 2 = Shelter
    //Collection: 0 = No Collection Fee, 1 = Add Collection Fee (Default)
    //Currency: 0 = EGP (Default), 1 = USD, 2 = GBP
    public function MakeDonation($Type,$Amount,$DirectedTo,$Collection=1,$currency=0){
       $donation =new Donation($Type,$Amount,$DirectedTo,$Collection,$currency);
       $status = $donation->Donate();
       if($status){
        return $this->GetInvoice($donation);
       }
       else{
        return "Donation not successful";
       }
    }

    public function GetInvoice(Donation $Donation){
        return $Donation->GenerateInvoice();
    }

    public function RegisterEvent()
    {
        //to be done when events are implemented    
    }
}
