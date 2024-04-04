<?php

namespace SchwarzID\ObiUtils;

use SchwarzID\ObiUtils\Contracts\Number;
use SchwarzID\ObiUtils\Exceptions\InvalidSkuCheckDigit;
use SchwarzID\ObiUtils\Exceptions\InvalidSkuLength;
use SchwarzID\ObiUtils\Exceptions\NonNumericSku;

/***
 * @throws InvalidSkuLength
 */
readonly class Sku implements Number {
    protected int $number;
    protected int $checkDigit;

    /**
     * @throws InvalidSkuLength
     * @throws NonNumericSku
     * @throws InvalidSkuCheckDigit
     */
    public function __construct(
        int|string $number,
        bool $forceValidCheckDigit = true,
    ) {
        if (strlen($number) !== 7) {
            throw new InvalidSkuLength();
        }

        // allow only numbers
        if (!preg_match('/^\d+$/', $number)) {
            throw new NonNumericSku();
        }

        $originalCheckDigit = (int) substr($number, -1);

        $this->number = (int) substr($number, 0, -1);
        $this->checkDigit = self::calculateCheckDigit((string) $this->number);

        if (($originalCheckDigit !== $this->checkDigit) && $forceValidCheckDigit) {
            throw new InvalidSkuCheckDigit($this->checkDigit, $originalCheckDigit);
        }
    }

    public function getNumber(): string
    {
        return $this->number.$this->checkDigit;
    }

    public function getCheckDigit(): int
    {
        return $this->checkDigit;
    }

    public function getNumberWithoutCheckDigit(): string
    {
        return (string) $this->number;
    }

    public static function validate(string $input): bool
    {
        try {
            $sku = new self($input);
        } catch (InvalidSkuLength | NonNumericSku | InvalidSkuCheckDigit) {
            return false;
        }

        return $sku->getCheckDigit() === (int) substr($input, -1);
    }

    public static function calculateCheckDigit(string $number): int
    {
        $digits = array_map(fn ($digit) => (int) $digit, str_split($number));

        $checksum = 0;
        $iterator = 1;

        foreach ($digits as $digit) {
            if ($iterator % 2 === 0) {
                $digitTimesTwo = $digit * 2;

                if ($digitTimesTwo >= 10) {
                    $doubledDigits = array_map(fn ($digit) => (int) $digit, str_split((string) $digitTimesTwo));

                    foreach ($doubledDigits as $doubledDigit) {
                        $checksum += $doubledDigit;
                    }
                } else {
                    $checksum += $digitTimesTwo;
                }
            } else {
                $checksum += $digit;
            }

            $iterator++;
        }

        return $checksum % 10 === 0
            ? 0
            : 10 - ($checksum % 10);
    }

    public function __toString(): string
    {
        return $this->getNumber();
    }
}
