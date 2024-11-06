<?php

interface DonationStrategy{
    public function Donate() : bool;
    public function Description();
}

class ClothesDonation implements DonationStrategy{
    private $Quantity;
    public function __construct($Quantity)
    {
        $this->Quantity = $Quantity;
    }
    public function Donate() : bool{
        $inventory = new Inventory();
        return $inventory->AddClothesQuantity($this->Quantity);
    }
    public function Description()
    {
        return "You donated " + $this->Quantity + " articles of clothes";
    }
}
class FoodResourceDonation implements DonationStrategy{
    private $Quantity;
    public function __construct($Quantity)
    {
        $this->Quantity = $Quantity;
    }
    public function Donate() : bool{
        $inventory = new Inventory();
        return $inventory->AddFoodResourceQuantity($this->Quantity);
    }
    public function Description()
    {
        return "You donated " + $this->Quantity + " food resources";
    }
}
