<?php

namespace SchwarzID\ObiUtils\Contracts;

interface Number
{
    public function __construct(string $number);

    public function getNumber(): string;

    public function getCheckDigit(): int;

    public function getNumberWithoutCheckDigit(): string;
}
