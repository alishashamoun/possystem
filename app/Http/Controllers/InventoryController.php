<?php
// app/Http/Controllers/InventoryController.php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use App\Helpers\BarcodeGenerator;
use Log;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::with('product')->get();
        $products = Product::all();
        return view('admin.inventory.index', compact('inventories', 'products'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.inventory.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'quantity_action' => 'required|in:+,-',
        ]);

        $product = Product::find($request->input('product_id'));

        if (!$product) {
            return back()->withInput()->withErrors(['error' => 'Product not found.']);
        }

        if ($request->input('quantity_action') == '+') {
            // Stock in
            $this->stockIn($request);
        } elseif ($request->input('quantity_action') == '-') {
            // Stock out
            $this->stockOut($request);
        }

        return redirect()->route('inventory.index');
    }

    public function stockIn(Request $request)
    {
        $product = Product::find($request->input('product_id'));
        $stock = new Stock();
        $stock->product_id = $product->id;
        $stock->quantity = $request->input('quantity');
        $stock->type = 'in';
        $stock->save();

        $product->quantity += $request->input('quantity');
        $product->save();

        return redirect()->route('inventory.index');
    }

    public function stockOut(Request $request)
    {
        $product = Product::find($request->input('product_id'));
        if (!$product) {
            return back()->withInput()->withErrors(['error' => 'Product not found.']);
        }

        if ($product->quantity < $request->input('quantity')) {
            return back()->withInput()->withErrors(['error' => 'Not enough stock!']);
        }

        $stock = new Stock();
        $stock->product_id = $product->id;
        $stock->quantity = $request->input('quantity');
        $stock->type = 'out';
        $stock->save();

        $product->quantity -= $request->input('quantity');
        $product->save();

        return redirect()->route('inventory.index');
    }


    public function generateReport()
    {
        $products = Product::all();
        $report = [];

        foreach ($products as $product) {
            $stock = Stock::where('product_id', $product->id)->first();

            if ($stock) {
                $report[] = [
                    'product_name' => $product->name,
                    'quantity' => $stock->quantity,
                    'value' => $stock->quantity * $product->price,
                ];
            } else {
                $report[] = [
                    'product_name' => $product->name,
                    'quantity' => 0, // or some other default value
                    'value' => 0, // or some other default value
                ];
            }
        }

        return view('admin.inventory.report', compact('report'));
    }


    public function checkStockLevels()
    {
        $products = Product::all();
        $lowStockProducts = [];

        foreach ($products as $product) {
            $stock = Stock::where('product_id', $product->id)->first();

            if ($stock) {
                if ($stock->quantity < $product->threshold) {
                    $lowStockProducts[] = $product;
                }
            } else {
                // Log an error or send an alert if no stock record is found
                // ...
            }
        }

        return view('admin.low_stock_products', compact('lowStockProducts'));
    }

    public function edit($id)
    {
        $inventory = Inventory::find($id);
        $products = Product::all();
        return view('admin.inventory.edit', compact('inventory', 'products'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_id' => 'equired|exists:products,id',
            'quantity' => 'equired|integer',
        ]);

        $inventory = new Inventory($validatedData);
        $product = Product::find($request->input('product_id'));
        $inventory = Inventory::find($id);

        $inventory->update($request->all());
        return redirect()->route('inventory.index');
    }

    public function destroy($id)
    {
        $inventory = Inventory::find($id);
        $inventory->delete();
        return redirect()->route('inventory.index');
    }

    public function generateBarcode($id)
    {
        $product = Product::find($id);
        $barcode = BarcodeGenerator::generateBarcode($product->id, 'PHARMA');
        return view('barcode', compact('barcode'));
    }


}
