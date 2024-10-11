<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showPaymentForm($id)
    {
        // Fetch the product by ID
        $product = Product::findOrFail($id);

        // Pass product data to the view
        return view('payment-form', [
            'product' => $product
        ]);
    }

    /**
     * Handle the payment submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processPayment(Request $request)
    {
        // Validate form input
        $request->validate([
            'received_amount' => 'required|numeric',
            'paying_amount' => 'required|numeric',
            'change_return' => 'nullable|numeric',
            'payment_type' => 'required|string',
            'payment_status' => 'required|string',
        ]);

        // Handle payment processing logic here
        // For example, you can save the payment details to the database

        // Return a response, e.g., redirect to a success page
        return redirect()->route('payment.success')->with('success', 'Payment processed successfully!');
    }
}
