<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function printReceipt(Transaction $transaction)
    {
        $receipt = view('receipt', compact('transaction'))->render();
        // Print receipt using a printer or PDF generator
        //...
    }
}
