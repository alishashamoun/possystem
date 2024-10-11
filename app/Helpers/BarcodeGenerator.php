<?php

namespace App\Helpers;

use Milon\Barcode\Facades\DNS1DFacade;

class BarcodeGenerator
{
    public static function generateBarcode($code, $type = 'PHARMA')
    {
        return DNS1DFacade::getBarcodeHTML($code, $type);
    }
}
