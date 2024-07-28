<?php

namespace SchwarzID\ObiUtils\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use SchwarzID\ObiUtils\Exceptions\InvalidGtinCheckDigit;
use SchwarzID\ObiUtils\Exceptions\InvalidGtinLength;
use SchwarzID\ObiUtils\Exceptions\NonNumericGtin;
use SchwarzID\ObiUtils\Parser\Gtin;

class ValidGtin implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            new Gtin($value);
        } catch (\Exception $e) {
            match ($e::class) {
                InvalidGtinLength::class => $fail('The :attribute must be exactly 8 or 13 characters long.'),
                NonNumericGtin::class => $fail('The :attribute must be a numeric value.'),
                InvalidGtinCheckDigit::class => $fail('The :attribute has an invalid check digit.'),
                default => $fail('The :attribute is invalid.'),
            };
        }
    }
}
