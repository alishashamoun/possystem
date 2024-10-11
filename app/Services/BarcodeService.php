<?php
// BarcodeService.php (Service class)

namespace App\Services;

use App\Models\Product;

class BarcodeService
{
    public function generateBarcode(Product $product)
    {
        // Generate a unique barcode for the product
        $barcode = $this->generateUniqueBarcode();

        // Store the barcode in the product table
        $product->barcode = $barcode;
        $product->save();

        return $barcode;
    }

    private function generateUniqueBarcode()
    {
        // Implement a unique barcode generation algorithm (e.g., UUID, random string)
        // ...
    }

    public function printBarcode(Product $product)
    {
        // Generate a barcode image using a library like Barcode Generator
        $barcodeImage = $this->generateBarcodeImage($product->barcode);

        // Return the barcode image as a response
        return response($barcodeImage, 200)
            ->header('Content-Type', 'image/png');
    }

    private function generateBarcodeImage(string $barcode)
    {
        // Implement a barcode image generation algorithm using a library like Barcode Generator
        // ...
    }
}
