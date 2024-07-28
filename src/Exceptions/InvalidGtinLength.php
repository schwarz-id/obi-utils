<?php

namespace SchwarzID\ObiUtils\Exceptions;

use Exception;

class InvalidGtinLength extends Exception
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message === null ? 'The GTIN must be exactly 8 or 13 characters long.' : $message);
    }
}
