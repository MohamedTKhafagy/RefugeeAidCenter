<?php

require_once __DIR__ . '/../Models/InventoryModel.php';

class InventoryController
{
    public function showInventory()
    {
        $inventory = new Inventory();
        include __DIR__ . '/../views/InventoryDetailView.php';
    }
}
