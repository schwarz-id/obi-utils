<?php

namespace SchwarzID\ObiUtils\Exceptions;

use Exception;

class NonNumericGtin extends Exception
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message === null ? 'The GTIN must must be numeric and only consist of digits.' : $message);
    }
}
