<?php
// app/Http/Controllers/InventoryController.php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validators\Validator;

class InventoryController extends Controller
{
    public function index()
    {
        $inventoryItems = Inventory::all();
        return view('admin.inventory.index', compact('inventoryItems'));
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
            'sku' => 'required|string|unique:inventories,sku',
            'quantity' => 'required|integer|min:0',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ]);

        Inventory::create($request->all());

        return redirect()->route('inventory.index')->with('success', 'Product added to inventory!');
    }

    public function edit($id)
    {
        $products = Product::all();
        $inventoryItem = Inventory::findOrFail($id);
        $selectedProductId = $inventoryItem->product_id;
        return view('admin.inventory.edit', compact('inventoryItem', 'products', 'selectedProductId'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ]);

        $inventoryItem = Inventory::findOrFail($id);
        $inventoryItem->update($request->all());

        return redirect()->route('inventory.index')->with('success', 'Inventory updated successfully!');
    }

    public function destroy($id)
    {
        $inventoryItem = Inventory::findOrFail($id);
        $inventoryItem->delete();

        return redirect()->route('inventory.index')->with('success', 'Product removed from inventory.');
    }

      // Stock In Function
      public function stockIn(Request $request, $id)
      {
          $product = Product::find($id);

          if ($product) {
              $product->quantity += $request->input('quantity'); // Adding stock
              $product->save();

              return response()->json([
                  'message' => 'Stock added successfully.',
                  'product' => $product
              ]);
          }

          return response()->json(['message' => 'Product not found.'], 404);
      }

      // Stock Out Function
      public function stockOut(Request $request, $id)
      {
          $product = Product::find($id);

          if ($product) {
              $quantity = $request->input('quantity');

              if ($product->quantity >= $quantity) {
                  $product->quantity -= $quantity; // Reducing stock
                  $product->save();

                  return response()->json([
                      'message' => 'Stock reduced successfully.',
                      'product' => $product
                  ]);
              }

              return response()->json(['message' => 'Not enough stock available.'], 400);
          }

          return response()->json(['message' => 'Product not found.'], 404);
      }

}
