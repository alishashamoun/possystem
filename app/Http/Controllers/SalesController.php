<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Warehouse;
use DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\PaymentMethod;
use App\Models\Sale;
use Log;

class SalesController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $paymentMethods = PaymentMethod::all();
        $sales = Sale::all();
        $warehouse = Warehouse::all();

        return view('admin.sales.index', compact('products', 'paymentMethods', 'sales', 'warehouse'));
    }

    public function create()
    {
        $products = Product::all();
        $paymentMethods = PaymentMethod::all();
        $customers = Customer::all();
        $warehouses = Warehouse::all();

        $sales = Sale::with('products')->get();
        $sale = $sales->first();

        return view('admin.sales.create', compact('products', 'paymentMethods', 'customers', 'warehouses'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_id' => 'required|exists:customers,id',
            'warehouse' => 'required|string',
            'status' => 'required|string',
            'grand_total' => 'required|numeric',
            'paid' => 'required|numeric',
            'payment_status' => 'required|string',
            'payment_type' => 'required|string',
        ]);

        // Find the product and customer
        $product = Product::find($request->input('product_id'));
        $customer = Customer::find($request->input('customer_id'));

        if (!$product || !$customer) {
            return redirect()->route('sales.index')->with('error', 'Product or Customer not found');
        }

        // Create a new Sale record
        $sale = new Sale();
        $sale->product_id = $product->id; // Save the product ID
        $sale->customer_id = $customer->id; // Save the customer ID
        $sale->warehouse = $request->input('warehouse');
        $sale->status = $request->input('status');
        $sale->grand_total = $request->input('grand_total');
        $sale->paid = $request->input('paid');
        $sale->payment_status = $request->input('payment_status');
        $sale->payment_type = $request->input('payment_type');

        try {
            DB::beginTransaction();
            $sale->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating sale: ' . $e->getMessage());
            return redirect()->route('sales.index')->with('error', 'Failed to create sale.');
        }

        return redirect()->route('sales.index')->with('success', 'Sale created successfully.');
    }



  
    public function showSale()
    {
        $products = Product::all();
        $paymentMethods = PaymentMethod::all();
        $sales = Sale::all();
        // dd($products);
        return view('cashier.index', compact('sales', 'paymentMethods', 'products'));
    }

    public function edit($id){
        $sale = Sale::find($id);
        $products = Product::all();
        $customers = Customer::all();
        $warehouses = Warehouse::all();
        if (!$sale) {
            return redirect()->route('sales.index')->with('error', 'Sale not found');
        }

        return view('admin.sales.edit', compact('sale', 'products', 'customers', 'warehouses'));
    }


    public function update(Request $request, $id){
        $sale = Sale::find($id);
        $product = Product::find($request->input('product_id'));
        $customer = Customer::find($request->input('customer_id'));

        if (!$sale ||!$product ||!$customer) {
            return redirect()->route('sales.index')->with('error', 'Sale, Product or Customer not found');
        }

        $sale->product_id = $product->id; // Save the product ID
        $sale->customer_id = $customer->id; // Save the customer ID
        $sale->warehouse = $request->input('warehouse');
        $sale->status = $request->input('status');
        $sale->grand_total = $request->input('grand_total');
        $sale->paid = $request->input('paid');
        $sale->payment_status = $request->input('payment_status');
        $sale->payment_type = $request->input('payment_type');
        $sale->save();
        return redirect()->route('sales.index')->with('success', 'Sale updated successfully');

    }

    public function destroy($id){
        $sale = Sale::find($id);
        if (!$sale) {
            return redirect()->route('sales.index')->with('error', 'Sale not found');
        }
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully');
    }
}
