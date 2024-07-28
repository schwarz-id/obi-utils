<?php

namespace SchwarzID\ObiUtils\Exceptions;

use Exception;

class InvalidGtinCheckDigit extends Exception
{
    public function __construct($givenCheckDigit, $expectedCheckDigit)
    {
        parent::__construct('Invalid GTIN check digit, expected '.$expectedCheckDigit.' but got '.$givenCheckDigit.'.');
    }
}
