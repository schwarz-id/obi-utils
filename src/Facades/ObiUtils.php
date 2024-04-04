<?php

namespace SchwarzID\ObiUtils\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SchwarzID\ObiUtils\ObiUtils
 */
class ObiUtils extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SchwarzID\ObiUtils\ObiUtils::class;
    }
}
