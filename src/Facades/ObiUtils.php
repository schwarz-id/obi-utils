<?php

namespace SchwarzID\ObiUtils\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \SchwarzID\ObiUtils\ObiSku sku()
 * @method static \SchwarzID\ObiUtils\Gtin gtin()
 * @method static string generateBarcode($number)
 * @see \SchwarzID\ObiUtils\ObiUtils
 */
class ObiUtils extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SchwarzID\ObiUtils\ObiUtils::class;
    }
}
