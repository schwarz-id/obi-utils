<?php

namespace SchwarzID\ObiUtils\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use SchwarzID\ObiUtils\Exceptions\InvalidSkuCheckDigit;
use SchwarzID\ObiUtils\Exceptions\InvalidSkuLength;
use SchwarzID\ObiUtils\Exceptions\NonNumericSku;
use SchwarzID\ObiUtils\Parser\Sku;

class ValidSku implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            new Sku($value);
        } catch (\Exception $e) {
            match ($e::class) {
                InvalidSkuLength::class => $fail('The :attribute must be exactly 7 characters long.'),
                NonNumericSku::class => $fail('The :attribute must be a numeric value.'),
                InvalidSkuCheckDigit::class => $fail('The :attribute has an invalid check digit.'),
                default => $fail('The :attribute is invalid.'),
            };
        }
    }
}
