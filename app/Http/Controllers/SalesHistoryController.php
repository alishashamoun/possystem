<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class SalesHistoryController extends Controller
{
    public function index()
    {

        $products = Product::all();
        $paymentMethods = PaymentMethod::all();
        $sales = Sale::all();
        $warehouse = Warehouse::all();
        return view('admin.sales.sales-history', compact('sales', 'products', 'paymentMethods', 'warehouse'));
    }
}
