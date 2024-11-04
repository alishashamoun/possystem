<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerAccount;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    // This method would show the registration form
    public function showRegisterForm()
    {
        return view('auth.register'); // Assuming you have a custom registration view
    }

    // This method would handle the registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'username' => 'required|string|max:255|unique:customer_accounts',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $customer = Customer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ]);

        CustomerAccount::create([
            'customer_id' => $customer->id,
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
        ]);

        Auth::login($customer);

        return redirect()->route('customer.account.dashboard');
    }

    // This method would show the login form
    public function showLoginForm()
    {
        return view('auth.login'); // Assuming you have a custom login view
    }

    // This method would handle the login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('customer.account.dashboard');
        }

        return redirect()->back()->withErrors(['Invalid username or password']);
    }

    // Logout method
    public function logout()
    {
        Auth::logout();
        return redirect()->route('customer.login');
    }

    public function dashboard()
    {
        $products = Product::all();
        $sales = Sale::all();
        $customer = Auth::user();

        $purchases = $customer->purchases()->orderBy('purchase_date', 'desc')->get();

        return view('admin.customer.dashboard', compact('products', 'sales', 'customer', 'purchases'));
    }




}
