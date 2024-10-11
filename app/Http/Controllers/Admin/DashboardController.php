<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        // Total Sales Amount
        $totalSales = Sale::sum('grand_total');

        $totalAmount = Purchase::sum('total_amount');
        $todayTotalSales = Sale::whereDate('created_at', today())->sum('grand_total');

        $todayTotalPurchase = Purchase::whereDate('created_at', today())->sum('total_amount');

        $todayTotalReceived = Sale::whereDate('created_at', today())->sum('grand_total');

        return view('admin.dashboard', compact('totalSales','totalAmount', 'todayTotalSales', 'todayTotalPurchase', 'todayTotalReceived'));
    }
}
