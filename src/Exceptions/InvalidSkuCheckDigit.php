<?php

namespace SchwarzID\ObiUtils\Exceptions;

class InvalidSkuCheckDigit extends \Exception
{
    public function __construct($givenCheckDigit, $expectedCheckDigit)
    {
        parent::__construct('Invalid SKU check digit, expected '.$expectedCheckDigit.' but got '.$givenCheckDigit.'.');
    }
}
