<?php

it('validates a valid or missing sku', function ($sku) {
    \Illuminate\Support\Facades\Validator::make(['sku' => $sku], [
        'sku' => [new \SchwarzID\ObiUtils\Rules\ValidSku],
    ])->validate();
})
    ->with(['3761236', '',])
    ->throwsNoExceptions();

it('does not validate an invalid sku', function ($sku) {
    \Illuminate\Support\Facades\Validator::make(['sku' => $sku], [
        'sku' => [new \SchwarzID\ObiUtils\Rules\ValidSku],
    ])->validate();
})
    ->with(['3761237', '376123', '37612365', '3761236a', '3761236 ', ' 3761236',])
    ->throws(\Illuminate\Validation\ValidationException::class);
