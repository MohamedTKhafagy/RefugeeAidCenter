<?php

abstract class MoneyDonation implements DonationStrategy{
    abstract public function CalcPrice();
}

class HospitalDonation extends MoneyDonation{
    private $Amount;
    public function Donate()
    {
        $inventory = new Inventory();
        $inventory->AddMoney($this->CalcPrice());
    }
    public function CalcPrice()
    {
        return $this->Amount; 
    }
}
class ShelterDonation extends MoneyDonation{
    private $Amount;
    public function Donate()
    {
        $inventory = new Inventory();
        $inventory->AddMoney($this->CalcPrice());
    }
    public function CalcPrice()
    {
        return $this->Amount; 
    }
}
class SchoolDonation extends MoneyDonation{
    private $Amount;
    public function Donate()
    {
        $inventory = new Inventory();
        $inventory->AddMoney($this->CalcPrice());
    }
    public function CalcPrice()
    {
        return $this->Amount; 
    }
}

abstract class DonationDecorator{
    protected MoneyDonation $Donation;
}

class USDDecorator extends DonationDecorator{
    public function Donate()
    {
        $inventory = new Inventory();
        $inventory->AddMoney($this->CalcPrice());
    }
    public function CalcPrice()
    {
        return $this->Donation->CalcPrice()*49.12; 
    }
}
class TaxDecorator extends DonationDecorator{
    public function Donate()
    {
        $inventory = new Inventory();
        $inventory->AddMoney($this->CalcPrice());
    }
    public function CalcPrice()
    {
        return $this->Donation->CalcPrice()*0.85; 
    }
}
class CollectionFeeDecorator extends DonationDecorator{
    public function Donate()
    {
        $inventory = new Inventory();
        $inventory->AddMoney($this->CalcPrice());
    }
    public function CalcPrice()
    {
        return $this->Donation->CalcPrice()+50; 
    }
}
class GBPDecorator extends DonationDecorator{
    public function Donate()
    {
        $inventory = new Inventory();
        $inventory->AddMoney($this->CalcPrice());
    }
    public function CalcPrice()
    {
        return $this->Donation->CalcPrice()*63.97; 
    }
}
