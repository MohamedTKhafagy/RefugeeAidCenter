<?php
include_once "InventoryModel.php";

abstract class MoneyDonation implements DonationStrategy{
    abstract public function CalcPrice();
}

class HospitalDonation extends MoneyDonation implements DonationStrategy{
    private $Amount;
    public function __construct($Amount)
    {
        $this->Amount = $Amount;
    }
    public function Donate() : bool
    {
        $inventory = new Inventory();
        return $inventory->AddMoney($this->CalcPrice());
    }
    public function CalcPrice()
    {
        return $this->Amount; 
    }
    public function Description()
    {
        return "You donated " . $this->Amount  . " to the hospital.";
    }
}
class ShelterDonation extends MoneyDonation implements DonationStrategy{
    private $Amount;
    public function __construct($Amount)
    {
        $this->Amount = $Amount;
    }
    public function Donate() : bool
    {
        $inventory = new Inventory();
        return $inventory->AddMoney($this->CalcPrice());
    }
    public function CalcPrice()
    {
        return $this->Amount; 
    }
    public function Description()
    {
        return "You donated " . $this->Amount  . " to the shelter.";
    }
}
class SchoolDonation extends MoneyDonation implements DonationStrategy{
    private $Amount;
    public function __construct($Amount)
    {
        $this->Amount = $Amount;
    }
    public function Donate() : bool
    {
        $inventory = new Inventory();
        return $inventory->AddMoney($this->CalcPrice());
    }
    public function CalcPrice()
    {
        return $this->Amount; 
    }
    public function Description()
    {
        return "You donated " . $this->Amount  . " to the school.";
    }
}

abstract class DonationDecorator extends MoneyDonation implements DonationStrategy{
    protected MoneyDonation $Donation;
}

class USDDecorator extends DonationDecorator{
    public function __construct($Donation)
    {
        $this->Donation = $Donation;
    }
    public function Donate() : bool
    {
        $inventory = new Inventory();
        return $inventory->AddMoney($this->CalcPrice());
    }
    public function CalcPrice()
    {
        return $this->Donation->CalcPrice()*49.12; 
    }
    public function Description(){
        return $this->Donation->Description() . " After Converting to EGP the amount will be " .  $this->Donation->CalcPrice()*49.12 . ".";
    }
}
class TaxDecorator extends DonationDecorator implements DonationStrategy{
    public function __construct($Donation)
    {
        $this->Donation = $Donation;
    }
    public function Donate() : bool
    {
        $inventory = new Inventory();
        return $inventory->AddMoney($this->CalcPrice());
    }
    public function CalcPrice()
    {
        return $this->Donation->CalcPrice()*0.85; 
    }
    public function Description(){
        return $this->Donation->Description() . " After Deducting a Tax of 15% the total will be " . $this->Donation->CalcPrice()*0.85 . ".";
    }
}
class CollectionFeeDecorator extends DonationDecorator implements DonationStrategy{
    public function __construct($Donation)
    {
        $this->Donation = $Donation;
    }
    public function Donate() : bool
    {
        $inventory = new Inventory();
        return $inventory->AddMoney($this->CalcPrice());
    }
    public function CalcPrice()
    {
        return $this->Donation->CalcPrice()-50; 
    }
    public function Description(){
        return $this->Donation->Description() . " A collection fee is deducted to make the total " . $this->Donation->CalcPrice()-50 . ".";
    }
}
class GBPDecorator extends DonationDecorator implements DonationStrategy{
    public function __construct($Donation)
    {
        $this->Donation = $Donation;
    }
    public function Donate() : bool
    {
        $inventory = new Inventory();
        return $inventory->AddMoney($this->CalcPrice());
    }
    public function CalcPrice()
    {
        return $this->Donation->CalcPrice()*63.97; 
    }
    public function Description(){
        return $this->Donation->Description() . " After Converting to EGP the amount will be " .  $this->Donation->CalcPrice()*63.97 . ".";
    }
}
