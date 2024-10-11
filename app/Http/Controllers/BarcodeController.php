<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BarcodeService;
use App\Models\Product;

class BarcodeController extends Controller
{
    public function printBarcode($id)
    {
        $barcodeService = new BarcodeService();
        $product = Product::findOrFail($id);
        $barcode = $barcodeService->printBarcode($product);
        return view('barcode', compact('barcode', 'product'));
    }
}
