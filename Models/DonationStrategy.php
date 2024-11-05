<?php

interface DonationStrategy{
    public function Donate();
}

class ClothesDonation implements DonationStrategy{
    private $Quantity;
    public function Donate() {
        $inventory = new Inventory();
        $inventory->AddClothesQuantity($this->Quantity);
    }
}
class FoodResourceDonation implements DonationStrategy{
    private $Quantity;
    public function Donate() {
        $inventory = new Inventory();
        $inventory->AddFoodResourceQuantity($this->Quantity);
    }
}
