<?php

namespace SchwarzID\ObiUtils;

class ObiUtils
{
    public function sku(): ObiSku
    {
        return new ObiSku;
    }

    public function gtin(): Gtin
    {
        return new Gtin;
    }

    public function generateBarcode($number): ?string
    {
        if (\SchwarzID\ObiUtils\Facades\ObiUtils::gtin()->validate($number)) {
            return ObiBarcodeGenerator::fromGtinAsBase64($number);
        }

        return ObiBarcodeGenerator::fromSkuAsBase64($number);
    }
}
