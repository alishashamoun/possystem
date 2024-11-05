<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Order;
use App\Models\Sale;
use Carbon\Carbon;

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

        // line chart
        $salesData = Sale::selectRaw('SUM(grand_total) as total, MONTH(created_at) as month')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = [];
        $totals = [];

        foreach ($salesData as $data) {
            $months[] = Carbon::createFromFormat('m', $data->month)->format('F');
            $totals[] = $data->total;
        }

        // // pie chart

        // $beverageSales = Sale::whereHas('products.category', function ($query) {
        //     $query->where('categories.name', 'Beverage');
        // })->sum('grand_total');

        // $snackSales = Sale::whereHas('products.category', function ($query) {
        //     $query->where('categories.name', 'Snack');
        // })->sum('grand_total');

        // $labels = ['Beverage', 'Snack'];
        // $dataValues = [$beverageSales, $snackSales];



        return view('admin.dashboard', compact('totalSales', 'totalAmount', 'todayTotalSales', 'todayTotalPurchase', 'todayTotalReceived', 'recentCustomers', 'recentOrders', 'months', 'totals'));
    }
}
