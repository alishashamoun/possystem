<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // public function printReceipt($id)
    // {
    //     $transaction = Transaction::find($id);
    //     if ($transaction) {
    //         // Generate the receipt
    //         $receipt = "
    //         Receipt
    //         --------
    //         Date: {$transaction->date}
    //         Time: {$transaction->time}
    //         Items: {$transaction->items}
    //         Quantity: {$transaction->quantity}
    //         Price: ${$transaction->price}
    //         Total Amount: ${$transaction->total_amount}
    //         --------
    //         ";
    //         // Print the receipt
    //         echo $receipt;
    //     } else {
    //         echo "Transaction not found";
    //     }
    // }
}
