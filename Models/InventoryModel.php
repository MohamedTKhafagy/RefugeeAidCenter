<?php
class Inventory{
    private $Money;
    private $ClothesQuantity;
    private $FoodResourcesQuantity;

    //Getter Methods
    public function getMoney(){
        return $this->Money;
    }
    public function getClothesQuantity(){
        return $this->ClothesQuantity;
    }
    public function getFoodResources(){
        return $this->FoodResourcesQuantity;
    }

    //Setters Methods
    public function setMoney($Money){
        $this->Money = $Money;
        return true;
    }
    public function setClothesQuantity($ClothesQuantity){
        $this->ClothesQuantity = $ClothesQuantity;
        return true;
    }
    public function setFoodResourcesQuantity($FoodResourcesQuantity){
        $this->FoodResourcesQuantity= $FoodResourcesQuantity;
        return true;
    }

    //Incrementation Methods
    public function AddMoney($Money){
        $this->Money = $this->Money + $Money;
        return true;
    }
    public function AddClothesQuantity($ClothesQuantity){
        $this->ClothesQuantity = $this->ClothesQuantity + $ClothesQuantity;
        return true;
    }
    public function AddFoodResourceQuantity($FoodResourcesQuantity){
        $this->FoodResourcesQuantity = $this->FoodResourcesQuantity + $FoodResourcesQuantity;
        return true;
    }

    //Decrementation Methods
    public function RemoveMoney($Money){
        if($this->Money > 0){
            $this->Money = $this->Money - $Money;
            return true;
        }
        else{
            return false;
        }
    }
    public function RemoveClothesQuantity($ClothesQuantity){
        if($this->ClothesQuantity > 0){
            $this->ClothesQuantity = $this->ClothesQuantity - $ClothesQuantity;
            return true;
        }
        else{
            return false;
        }
    }
    public function RemoveFoodResourceQuantity($FoodResourcesQuantity){
        if($this->FoodResourcesQuantity > 0){
            $this->FoodResourcesQuantity = $this->FoodResourcesQuantity - $FoodResourcesQuantity;
            return true;
        }
        else{
            return false;
        }
    }
}