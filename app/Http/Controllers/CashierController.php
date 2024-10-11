<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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

    // public function dashboard()
    // {

    //     $products = Product::all();
    //     $sales = Sale::all();
    //     return view('cashier.dashboard', compact('products', 'sales'));
    // }

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
        Log::info('Form submitted data: ', $request->all());

        $rules = [
            'received_amount' => 'required|numeric|min:0',
            'paying_amount' => 'numeric|min:0',
            'change_return' => 'numeric|min:0',
            'customer_id' => 'required|exists:customers,id',
            'sale_id' => 'nullable|exists:sales,id',
            'payment_gateway_transaction_id' => 'nullable|string',
            'payment_type' => 'string',
            'payment_status' => 'string|in:paid,unpaid',
            'warehouse' => 'string',
            'status' => 'required|string',
            'grand_total' => 'nullable|numeric',
            'paid' => 'nullable|numeric',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0.01',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info($validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // $productIds = $request->input('products', []);




        DB::beginTransaction();
        try {
            // Step 1: Create a new Sale
            $sale = new Sale();
            $sale->customer_id = $request->input('customer_id');
            $sale->warehouse = $request->input('warehouse');
            $sale->status = $request->input('status');
            $sale->grand_total = $request->input('grand_total');
            $sale->paid = $request->input('paid');
            $sale->payment_status = $request->input('payment_status');
            $sale->payment_type = $request->input('payment_type');
            $sale->save();

            // $sale->products()->attach($request['products']);

            // Loop through products and save to pivot table
            foreach ($request->products as $product) {
                // Assuming you have a pivot table like 'product_sale'
                DB::table('product_sale')->insert([
                    'sale_id' => $sale->id, // Sale or Order ID
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $sale->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);



            // Step 4: Save payment details
            $paymentDetail = new PaymentDetail();
            $paymentDetail->customer_id = $request->input('customer_id');
            $paymentDetail->sale_id = $sale->id;
            $paymentDetail->received_amount = $request->input('received_amount');
            $paymentDetail->paying_amount = $request->input('paying_amount');
            $paymentDetail->change_return = $request->input('change_return');
            $paymentDetail->payment_gateway_transaction_id = $request->input('payment_gateway_transaction_id');
            $paymentDetail->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data Inserted Successfully!'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment processing failed: ' . $e->getMessage());
            return response()->json(['error' => 'Payment processing failed'], 500);
        }
    }

}
