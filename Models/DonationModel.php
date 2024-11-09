<?php

include_once "DonationStrategy.php";
include_once "MoneyDonationDecorator.php";
class Donation {
    private $ID;
    private DonationStrategy $DonationStrategy;
    private $Amount;
    private $Type;
    private $DirectedTo;
    private $Collection;
    private $currency;

    public function __construct($Type,$Amount,$DirectedTo,$Collection=1,$currency=0){
        $this->Type = $Type;
        $this->Amount = $Amount;
        $this->DirectedTo = $DirectedTo;
        $this->Collection = $Collection;
        $this->currency = $currency;
        $this->InitializeDonationStrategy();
    }
    //Type: 0 = Money, 1 = Clothes, 2 = Food
    //DirectedTo: 0 = Hospital, 1 = School, 2 = Shelter
    //Collection: 0 = No Collection Fee, 1 = Add Collection Fee (Default)
    //Currency: 0 = EGP (Default), 1 = USD, 2 = GBP
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
    public function setID($ID) {
        $this->ID = $ID;
    }
    public function setDonationStrategy($DonationStrategy){
        $this->DonationStrategy = $DonationStrategy;
    }

    // Getter methods
    public function getID() {
        return $this->ID;
    }
    public function GenerateInvoice(){
        return $this->DonationStrategy->Description();
    }
    public function Donate(){
        return $this->DonationStrategy->Donate();
    }
}

