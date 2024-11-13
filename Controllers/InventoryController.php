<?php

require_once __DIR__ . '/../Models/InventoryModel.php';

class InventoryController
{
    public function showAllInventory()
    {
        $inventoryItems = Inventory::getAll();
        include __DIR__ . '/../views/InventoryListView.php';
    }

    public function showInventory()
    {
        $inventory = new Inventory();
        if ($inventory) {
            include __DIR__ . '/../views/InventoryDetailView.php';
        } else {
            echo "Inventory item not found.";
        }
    }
}