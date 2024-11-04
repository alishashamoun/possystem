<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Order;
use App\Models\Sale;

class DashboardController extends Controller
{

    public function index()
    {
        $totalSales = Sale::sum('grand_total');

        $totalAmount = Purchase::sum('total_amount');
        $todayTotalSales = Sale::whereDate('created_at', today())->sum('grand_total');

        $todayTotalPurchase = Purchase::whereDate('created_at', today())->sum('total_amount');

        $todayTotalReceived = Sale::whereDate('created_at', today())->sum('grand_total');

        $recentCustomers = Customer::orderBy('created_at', 'desc')->take(5)->get();

        $recentOrders = Order::with('products')->latest()->take(5)->get();

        $sales = Sale::whereMonth('created_at', 10)
            ->whereYear('created_at', date('Y'))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(grand_total) as total_sales')
            ->groupBy('date')
            ->get();

        $chartData = $sales->map(function ($sale) {
            return [
                'date' => $sale->date,
                'count' => $sale->count,
                'total_sales' => $sale->total_sales,
            ];
        });

        //  dd($chartData);


        return view('admin.dashboard', compact('totalSales', 'totalAmount', 'todayTotalSales', 'todayTotalPurchase', 'todayTotalReceived', 'recentCustomers', 'recentOrders', 'chartData'));
    }
}
