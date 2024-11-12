<?php
class Inventory
{
    //private $InventoryID;
    private $Money;
    private $ClothesQuantity;
    private $FoodResourcesQuantity;

    private static $file = __DIR__ . '/../data/inventory.txt';

    public function __construct()
    {
        $this->GetLatestUpdates();
    }

    // Getter Methods

    public function getMoney()
    {
        $this->GetLatestUpdates();
        return $this->Money;
    }

    public function getClothesQuantity()
    {
        $this->GetLatestUpdates();
        return $this->ClothesQuantity;
    }

    public function getFoodResources()
    {
        $this->GetLatestUpdates();
        return $this->FoodResourcesQuantity;
    }

    // Setter Methods
    public function setMoney($Money)
    {
        $this->GetLatestUpdates();
        $this->Money = max(0, $Money); // Ensure non-negative values
        $this->save();
        return true;
    }

    public function setClothesQuantity($ClothesQuantity)
    {
        $this->GetLatestUpdates();
        $this->ClothesQuantity = max(0, $ClothesQuantity);
        $this->save();
        return true;
    }

    public function setFoodResourcesQuantity($FoodResourcesQuantity)
    {
        $this->GetLatestUpdates();
        $this->FoodResourcesQuantity = max(0, $FoodResourcesQuantity);
        $this->save();
        return true;
    }

    // Incrementation Methods
    public function addMoney($Money)
    {
        $this->GetLatestUpdates();
        $this->Money += $Money;
        $this->save();
        return true;
    }

    public function addClothesQuantity($ClothesQuantity)
    {
        $this->GetLatestUpdates();
        $this->ClothesQuantity += $ClothesQuantity;
        $this->save();
        return true;
    }

    public function addFoodResourceQuantity($FoodResourcesQuantity)
    {
        $this->GetLatestUpdates();
        $this->FoodResourcesQuantity += $FoodResourcesQuantity;
        $this->save();
        return true;
    }

    // Decrementation Methods
    public function removeMoney($Money)
    {
        $this->GetLatestUpdates();
        if ($this->Money >= $Money) {
            $this->Money -= $Money;
            $this->save();
            return true;
        }
        return false;
    }

    public function removeClothesQuantity($ClothesQuantity)
    {
        $this->GetLatestUpdates();
        if ($this->ClothesQuantity >= $ClothesQuantity) {
            $this->ClothesQuantity -= $ClothesQuantity;
            $this->save();
            return true;
        }
        return false;
    }

    public function removeFoodResourceQuantity($FoodResourcesQuantity)
    {
        $this->GetLatestUpdates();
        if ($this->FoodResourcesQuantity >= $FoodResourcesQuantity) {
            $this->FoodResourcesQuantity -= $FoodResourcesQuantity;
            $this->save();
            return true;
        }
        return false;
    }

    // Save or update the inventory data in the text file
    public function save()
    {
        // Load existing data
        $data = file_exists(self::$file) ? json_decode(file_get_contents(self::$file), true) : [];

        // Add the current inventory data
        $data= [
            "Money" => $this->Money,
            "ClothesQuantity" => $this->ClothesQuantity,
            "FoodResourcesQuantity" => $this->FoodResourcesQuantity,
        ];

        // Write updated data back to the file
        file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT));
    }

    // Static method to get all inventories from the text file
    public static function getAll()
    {
        if (file_exists(self::$file)) {
            return json_decode(file_get_contents(self::$file), true);
        }
        return [];
    }

    // Static method to find an inventory by ID
    private function GetLatestUpdates()
    {
        $inventory = self::getAll();
        if($inventory != null){
                $this->Money =  $inventory['Money'];
                $this->ClothesQuantity = $inventory['ClothesQuantity'];
                $this->FoodResourcesQuantity = $inventory['FoodResourcesQuantity'];
        }
        }
       
    }
