<?php

namespace SchwarzID\ObiUtils\Parser;

use SchwarzID\ObiUtils\Contracts\Number;

readonly class Gtin implements Number
{
    public function __construct(
        protected string $number
    ) {
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getCheckDigit(): int
    {
        return (int) substr($this->number, -1);
    }

    public function getNumberWithoutCheckDigit(): string
    {
        return substr($this->number, 0, -1);
    }
}
