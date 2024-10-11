<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier')->get();
        return view('admin.purchases.index', compact('purchases'));
    }

    // Show form to create new purchase
    public function create()
    {
        $suppliers = Supplier::all(); // Get all suppliers
        return view('admin.purchases.create', compact('suppliers'));
    }

    // Store new purchase
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'payment_status' => 'required|string',
        ]);

        Purchase::create($request->all());

        return redirect()->route('purchases.index')->with('success', 'Purchase added successfully');
    }

    // Show form to edit purchase
    public function edit(Purchase $purchase)
    {
        $suppliers = Supplier::all();
        return view('admin.purchases.edit', compact('purchase', 'suppliers'));
    }

    // Update purchase
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'payment_status' => 'required|string',
        ]);

        $purchase->update($request->all());

        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully');
    }

    // Delete purchase
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully');
    }
}
