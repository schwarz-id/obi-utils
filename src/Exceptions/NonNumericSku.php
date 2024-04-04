<?php

namespace SchwarzID\ObiUtils\Exceptions;

class NonNumericSku extends \Exception
{
    public function __construct()
    {
        parent::__construct('SKU must be numeric and only consist of digits.');
    }
}
