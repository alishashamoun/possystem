<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function showSalesReport()
    {
        $products = Product::with('sales')->get();

        $productNames = $products->pluck('name');

        $quantitiesSold = $products->map(function ($product) {
            return $product->sales->sum('pivot.quantity');
        });

        return view('sales_report', compact('productNames', 'quantitiesSold'));
    }


}
