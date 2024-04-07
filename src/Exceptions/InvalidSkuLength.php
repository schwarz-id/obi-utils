<?php

namespace SchwarzID\ObiUtils\Exceptions;

class InvalidSkuLength extends \Exception
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message === null ? 'The SKU must be exactly 7 characters long.' : $message);
    }
}
