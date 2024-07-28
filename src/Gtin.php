<?php

namespace SchwarzID\ObiUtils;

use SchwarzID\ObiUtils\Exceptions\InvalidGtinCheckDigit;
use SchwarzID\ObiUtils\Exceptions\InvalidGtinLength;
use SchwarzID\ObiUtils\Exceptions\NonNumericGtin;

class Gtin
{
    public function validate(int|string $gtin): bool
    {
        try {
            new Parser\Gtin($gtin);

            return true;
        } catch (NonNumericGtin|InvalidGtinLength|InvalidGtinCheckDigit) {
            return false;
        }
    }

    /**
     * @throws InvalidGtinLength
     * @throws NonNumericGtin
     * @throws InvalidGtinCheckDigit
     */
    public function withCheckDigit(int|string $gtin): string
    {
        $gtin = match (strlen((string) $gtin)) {
            13, 8 => $gtin,
            12, 7 => $gtin.'0',
            default => throw new InvalidGtinLength,
        };

        return (new Parser\Gtin($gtin, throwOnInvalidCheckDigit: false))->getNumber();
    }

    /**
     * @throws NonNumericGtin
     * @throws InvalidGtinLength
     * @throws InvalidGtinCheckDigit
     */
    public function calculateCheckDigit(int|string $number): int
    {
        $number = match (strlen((string) $number)) {
            13, 8 => $number,
            12, 7 => $number.'0',
            default => throw new InvalidGtinLength,
        };

        return (new Parser\Gtin($number, throwOnInvalidCheckDigit: false))->getCheckDigit();
    }
}
