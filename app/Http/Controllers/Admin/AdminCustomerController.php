<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filename = null;
        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('customerImage'), $filename);
        }


        try {
            Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'image' => $filename,
            ]);


            return redirect()->route('customers.index')
                ->with('success', 'Customer created successfully.');
        } catch (\Exception $e) {
            \Log::error('Customer creation failed: ' . $e->getMessage());
            return redirect()->route('customers.index')
                ->with('error', 'Failed to create customer: ' . $e->getMessage());
        }

    }


    public function show($id)
    {
        $customer = Customer::find($id);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $filename = $customer->image;

        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('customerImage'), $filename);
        }
        try {
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'image' =>  $filename,
            ]);

            return redirect()->route('customers.index')
                ->with('success', 'Customer updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('customers.index')
                ->with('error', 'Failed to update customer: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return redirect()->back()->with('success', 'Customer deleted successfully.');
    }
    public function addLoyaltyPoints($customerId, Request $request)
    {
        $customer = Customer::find($customerId);
        $customer->loyalty_points += $request->input('points');
        $customer->save();

        return redirect()->back()->with('success', 'Loyalty points added successfully.');
    }

}
