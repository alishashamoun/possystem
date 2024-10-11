<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\Product;

class InventoryService
{
    public function updateStockLevel(Product $product, int $quantity, string $action)
    {
        $inventory = $product->inventory;

        if (!$inventory) {
            $inventory = new Inventory();
            $inventory->product_id = $product->id;
            $inventory->stock_level = 0;
            $inventory->low_stock_threshold = 10;
            $inventory->out_of_stock_threshold = 0;
            $inventory->save();
        }

        switch ($action) {
            case 'add':
                $inventory->stock_level += $quantity;
                break;
            case 'remove':
                $inventory->stock_level -= $quantity;
                break;
            case 'sell':
                $inventory->stock_level -= $quantity;
                break;
        }

        $inventory->save();

        // Check for low stock or out of stock alerts
        $this->checkStockThresholds($inventory);
    }

    private function checkStockThresholds(Inventory $inventory)
    {
        if ($inventory->stock_level <= $inventory->low_stock_threshold) {
            // Send low stock alert notification
            // ...
        }

        if ($inventory->stock_level <= $inventory->out_of_stock_threshold) {
            // Send out of stock alert notification
            // ...
        }
    }
}

