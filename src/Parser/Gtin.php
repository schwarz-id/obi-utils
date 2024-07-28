<?php

namespace SchwarzID\ObiUtils\Parser;

use SchwarzID\ObiUtils\Contracts\Number;
use SchwarzID\ObiUtils\Exceptions\InvalidGtinCheckDigit;
use SchwarzID\ObiUtils\Exceptions\InvalidGtinLength;
use SchwarzID\ObiUtils\Exceptions\NonNumericGtin;

readonly class Gtin implements Number
{
    protected int $inputCheckDigit;
    protected int $number;
    protected int $checkDigit;

    /**
     * @throws NonNumericGtin
     * @throws InvalidGtinLength
     * @throws InvalidGtinCheckDigit
     */
    public function __construct(
        int|string $number,
        bool       $throwOnInvalidCheckDigit = true,
    ) {
        $number = (string) $number;

        match (strlen($number)) {
            13, 8 => null,
            default => throw new InvalidGtinLength(),
        };

        // allow only numbers
        if (! preg_match('/^\d+$/', $number)) {
            throw new NonNumericGtin();
        }

        $this->inputCheckDigit = (int) substr($number, -1);

        $this->number = (int) substr($number, 0, -1);
        $this->checkDigit = $this->calculateCheckDigit((string) $this->number);

        if (($this->inputCheckDigit !== $this->checkDigit) && $throwOnInvalidCheckDigit) {
            throw new InvalidGtinCheckDigit($this->checkDigit, $this->inputCheckDigit);
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

    public function calculateCheckDigit(string $number): int
    {
        $digits = array_map(fn ($digit) => (int) $digit, array_reverse(str_split($number)));

        $checksum = 0;
        $iterator = 1;

        foreach ($digits as $digit) {
            $checksum += $iterator % 2 === 1 ? $digit * 3 : $digit;
            $iterator++;
        }

        return (10 - ($checksum % 10)) % 10;
    }

    public function __toString(): string
    {
        return $this->getNumber();
    }
}
