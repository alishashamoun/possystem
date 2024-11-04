<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Sale;
use DB;
use Illuminate\Http\Request;

class InventoryHistoryController extends Controller
{
    public function inventoryReport()
    {
        $products = Product::with('category')
        ->leftJoin('sale_product', 'products.id', '=', 'sale_product.product_id')
        ->select('products.*', \DB::raw('SUM(sale_product.quantity) as sold_quantity'))
        ->groupBy('products.id')
        ->get();

        return view('admin.inventory.inventory-report', compact('products'));
    }


}
