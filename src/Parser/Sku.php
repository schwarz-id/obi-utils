<?php

namespace SchwarzID\ObiUtils\Parser;

use SchwarzID\ObiUtils\Contracts\Number;
use SchwarzID\ObiUtils\Exceptions\InvalidSkuCheckDigit;
use SchwarzID\ObiUtils\Exceptions\InvalidSkuLength;
use SchwarzID\ObiUtils\Exceptions\NonNumericSku;

/***
 * @throws InvalidSkuLength
 */
readonly class Sku implements Number
{
    protected int $inputCheckDigit;

    protected int $number;

    protected int $checkDigit;

    /**
     * @throws InvalidSkuLength
     * @throws NonNumericSku
     * @throws InvalidSkuCheckDigit
     */
    public function __construct(
        int|string $number,
        bool $throwOnInvalidCheckDigit = true,
    ) {
        $number = (string) $number;

        if (strlen($number) !== 7) {
            throw new InvalidSkuLength();
        }

        // allow only numbers
        if (! preg_match('/^\d+$/', $number)) {
            throw new NonNumericSku();
        }

        $this->inputCheckDigit = (int) substr($number, -1);

        $this->number = (int) substr($number, 0, -1);
        $this->checkDigit = $this->calculateCheckDigit((string) $this->number);

        if (($this->inputCheckDigit !== $this->checkDigit) && $throwOnInvalidCheckDigit) {
            throw new InvalidSkuCheckDigit($this->checkDigit, $this->inputCheckDigit);
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

    public function getInputCheckDigit(): int
    {
        return $this->inputCheckDigit;
    }

    public function getNumberWithoutCheckDigit(): string
    {
        return (string) $this->number;
    }

    public function validate(int|string $input): bool
    {
        return $this->getCheckDigit() === $this->getInputCheckDigit();
    }

    public function calculateCheckDigit(string $number): int
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
