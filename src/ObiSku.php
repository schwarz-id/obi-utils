<?php

namespace SchwarzID\ObiUtils;

use SchwarzID\ObiUtils\Exceptions\InvalidSkuCheckDigit;
use SchwarzID\ObiUtils\Exceptions\InvalidSkuLength;
use SchwarzID\ObiUtils\Exceptions\NonNumericSku;
use SchwarzID\ObiUtils\Parser\Sku;

class ObiSku
{
    public function validate(int|string $sku): bool
    {
        try {
            $sku = new Sku($sku);

            return true;
        } catch (NonNumericSku|InvalidSkuLength|InvalidSkuCheckDigit) {
            return false;
        }
    }

    /**
     * @throws InvalidSkuLength
     * @throws NonNumericSku
     * @throws InvalidSkuCheckDigit
     */
    public function withCheckDigit(int|string $sku): string
    {
        $sku = strlen((string) $sku) === 6 ? $sku.'0' : $sku;

        if (strlen((string) $sku) !== 7) {
            throw new InvalidSkuLength('The SKU must be exactly 6 or 7 characters long.');
        }

        return (new Sku($sku, throwOnInvalidCheckDigit: false))->getNumber();
    }

    /**
     * @throws NonNumericSku
     * @throws InvalidSkuLength
     * @throws InvalidSkuCheckDigit
     */
    public function calculateCheckDigit(int|string $number): int
    {
        $number = (string) $number;

        // Add a trailing zero if the number is only 6 digits long
        $number = strlen($number) === 6 ? $number.'0' : $number;

        return (new Sku($number, throwOnInvalidCheckDigit: false))->getCheckDigit();
    }
}
