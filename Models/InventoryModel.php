<?php
class Inventory
{
    private $InventoryID;
    private $Money;
    private $ClothesQuantity;
    private $FoodResourcesQuantity;

    private static $file = __DIR__ . '/../data/inventories.txt';

    public function __construct($InventoryID, $money = 0, $clothes = 0, $food = 0)
    {
        $this->InventoryID = $InventoryID;
        $this->Money = $money;
        $this->ClothesQuantity = $clothes;
        $this->FoodResourcesQuantity = $food;
    }

    // Getter Methods
    public function getInventoryID()
    {
        return $this->InventoryID;
    }

    public function getMoney()
    {
        return $this->Money;
    }

    public function getClothesQuantity()
    {
        return $this->ClothesQuantity;
    }

    public function getFoodResources()
    {
        return $this->FoodResourcesQuantity;
    }

    // Setter Methods
    public function setMoney($Money)
    {
        $this->Money = max(0, $Money); // Ensure non-negative values
        $this->save();
        return true;
    }

    public function setClothesQuantity($ClothesQuantity)
    {
        $this->ClothesQuantity = max(0, $ClothesQuantity);
        $this->save();
        return true;
    }

    public function setFoodResourcesQuantity($FoodResourcesQuantity)
    {
        $this->FoodResourcesQuantity = max(0, $FoodResourcesQuantity);
        $this->save();
        return true;
    }

    // Incrementation Methods
    public function addMoney($Money)
    {
        $this->Money += $Money;
        $this->save();
        return true;
    }

    public function addClothesQuantity($ClothesQuantity)
    {
        $this->ClothesQuantity += $ClothesQuantity;
        $this->save();
        return true;
    }

    public function addFoodResourceQuantity($FoodResourcesQuantity)
    {
        $this->FoodResourcesQuantity += $FoodResourcesQuantity;
        $this->save();
        return true;
    }

    // Decrementation Methods
    public function removeMoney($Money)
    {
        if ($this->Money >= $Money) {
            $this->Money -= $Money;
            $this->save();
            return true;
        }
        return false;
    }

    public function removeClothesQuantity($ClothesQuantity)
    {
        if ($this->ClothesQuantity >= $ClothesQuantity) {
            $this->ClothesQuantity -= $ClothesQuantity;
            $this->save();
            return true;
        }
        return false;
    }

    public function removeFoodResourceQuantity($FoodResourcesQuantity)
    {
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

        // Remove any existing entry with the same InventoryID
        $data = array_filter($data, function ($inventory) {
            return $inventory['InventoryID'] !== $this->InventoryID;
        });

        // Add the current inventory data
        $data[] = [
            "InventoryID" => $this->InventoryID,
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
    public static function findById($InventoryID)
    {
        $inventories = self::getAll();
        foreach ($inventories as $inventory) {
            if ($inventory['InventoryID'] == $InventoryID) {
                return new self(
                    $inventory['InventoryID'],
                    $inventory['Money'],
                    $inventory['ClothesQuantity'],
                    $inventory['FoodResourcesQuantity']
                );
            }
        }
        return null;
    }
}
