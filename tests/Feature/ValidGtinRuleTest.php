<?php

it('validates a valid or missing gtin', function ($gtin) {
    \Illuminate\Support\Facades\Validator::make(['gtin' => $gtin], [
        'gtin' => [new \SchwarzID\ObiUtils\Rules\ValidGtin],
    ])->validate();
})
    ->with(['4002846034207', ''])
    ->throwsNoExceptions();

it('does not validate an invalid gtin', function ($gtin) {
    \Illuminate\Support\Facades\Validator::make(['gtin' => $gtin], [
        'gtin' => [new \SchwarzID\ObiUtils\Rules\ValidGtin],
    ])->validate();
})
    ->with(['4002846034206', '400284603420', '40028460342071', '4002846034207a', '4002846034207 ', ' 4002846034207'])
    ->throws(\Illuminate\Validation\ValidationException::class);
