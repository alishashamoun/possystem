<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentDetail;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Warehouse;
use App\Rules\AvailableInventory;
use DB;
use Illuminate\Http\Request;
use Log;
use Validator;

class CashierController extends Controller
{
    public function index()
    {
        $sale = Sale::get();
        $products = Product::get();
        $warehouses = Warehouse::get();
        $customers = Customer::get();

        return view('cashier.index', compact('products', 'sale', 'warehouses', 'customers'));
    }
    private function calculateTotalAmount()
    {
        $products = Product::all();
        return $products->sum(function ($product) {
            return $product->price * $product->quantity;
        });
    }
    public function showPaymentForm()
    {
        $product = Product::all();
        $sale = Sale::all();
        $totalAmount = $this->calculateTotalAmount();

        return view('cashier.index', compact('totalAmount', 'product', 'sale'));
    }
    public function processPayment(Request $request)
    {
        Log::info($request->all());

        $validatedData = $request->validate([
            'received_amount' => 'required|numeric|min:0',
            'paying_amount' => 'numeric|min:0',
            'change_return' => 'numeric|min:0',
            'customer_id' => 'required|exists:customers,id',
            'payment_type' => 'string',
            'payment_status' => 'string|in:paid,unpaid',
            'warehouse' => 'string',
            'status' => 'required|string',
            'grand_total' => 'nullable|numeric',
            'paid' => 'nullable|numeric',
            'products' => 'required|array',
            'products.*.id' => 'required|integer',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {

        if ($validatedData['customer_id'] === 'walk_in') {
            $customer = Customer::firstOrCreate([
                'name' => 'Walk-In Customer',
                'email' => null,
                'address' => null,
                'phone' => null,
            ]);

            $customerId = $customer->id;
        } else {
            $customerId = $validatedData['customer_id'];
        }
            // Create a new Sale first
            $sale = Sale::create([
                'customer_id' => $customerId,
                'warehouse' => $validatedData['warehouse'],
                'status' => $validatedData['status'],
                'grand_total' => $validatedData['grand_total'],
                'paid' => $validatedData['paid'],
                'payment_status' => $validatedData['payment_status'],
                'payment_type' => $validatedData['payment_type'],
            ]);

            // Create payment details for the sale
            PaymentDetail::create([
                'customer_id' => $customerId,
                'sale_id' => $sale->id,
                'received_amount' => $validatedData['received_amount'],
                'paying_amount' => $validatedData['paying_amount'],
                'change_return' => $validatedData['change_return'],
                'payment_gateway_transaction_id' => $request->input('payment_gateway_transaction_id'),
            ]);

            // Create a new Order
            $order = Order::create([
                'customer_id' => $customerId,
                'payment_status' => $validatedData['payment_status'],
                'status' => $validatedData['status'],
            ]);

            // Attach products to the order and sale
            foreach ($validatedData['products'] as $product) {
                $order->products()->attach($product['id'], [
                    'price' => $product['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $sale->products()->attach($product['id'], [
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ]);

            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Data Inserted Successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment processing failed: ' . $e->getMessage());
            return response()->json(['error' => 'Payment processing failed'], 500);
        }
    }



}
