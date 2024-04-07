<?php

namespace SchwarzID\ObiUtils;

use SchwarzID\ObiUtils\Exceptions\InvalidSkuCheckDigit;
use SchwarzID\ObiUtils\Exceptions\InvalidSkuLength;
use SchwarzID\ObiUtils\Exceptions\NonNumericSku;

class ObiUtils
{
    public function sku(): ObiSku
    {
        return new ObiSku();
    }
}
