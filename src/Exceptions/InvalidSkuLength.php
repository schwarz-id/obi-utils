<?php

namespace SchwarzID\ObiUtils\Exceptions;

class InvalidSkuLength extends \Exception
{
    public function __construct()
    {
        parent::__construct('The SKU must be exactly 7 characters long.');
    }
}
