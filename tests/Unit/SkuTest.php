<?php

it('does not accept skus with an invalid length', function ($sku) {
    new \SchwarzID\ObiUtils\Sku($sku);
})
    ->with(['12345678', '123456', '12', '42349324823094802348092348230423', '', '1'])
    ->throws(\SchwarzID\ObiUtils\Exceptions\InvalidSkuLength::class);

it('does not accept skus with non-numeric characters', function ($sku) {
    new \SchwarzID\ObiUtils\Sku($sku);
})
    ->with(['123456A', '123456B', '12C3456', '1231.21', '1231,51'])
    ->throws(\SchwarzID\ObiUtils\Exceptions\NonNumericSku::class);

it('does not accept skus with an invalid checksum', function ($sku) {
    new \SchwarzID\ObiUtils\Sku($sku);
})
    ->with(['1234567', '1234568', '1234569', '1234560', '1234561', '1234562', '1234563', '1234564', '1234565'])
    ->throws(\SchwarzID\ObiUtils\Exceptions\InvalidSkuCheckDigit::class);

it('accepts valid skus as string or integer', function ($sku) {
    $skuObj = new \SchwarzID\ObiUtils\Sku($sku);

    expect($skuObj->getNumber())->toBe((string) $sku);
})->with(['1234566', 1234566]);

it('accepts valid skus', function ($sku) {
    $skuObj = new \SchwarzID\ObiUtils\Sku($sku);

    expect($skuObj->getNumber())->toBe($sku);
})->with(['1234566', '3761236']);

it('can be cast to string', function ($sku) {
    $skuObj = new \SchwarzID\ObiUtils\Sku($sku);

    expect((string) $skuObj)->toBe($sku);
})->with(['1234566', '3761236']);

it('can return the check digit and number with out check digit', function ($sku) {
    $skuObj = new \SchwarzID\ObiUtils\Sku($sku);

    expect($skuObj->getCheckDigit())->toBe((int) substr($sku, -1))
        ->and($skuObj->getNumberWithoutCheckDigit())->toBe(substr($sku, 0, -1));
})->with(['1234566', '3761236']);

it('can force accept skus with an invalid check digit and return the valid check digit', function ($invalidSku, $validCheckDigit) {
    $skuObj = new \SchwarzID\ObiUtils\Sku($invalidSku, forceValidCheckDigit: false);

    expect($skuObj->getCheckDigit())->toBe($validCheckDigit);
})->with(
    [
        ['1234567', 6],
        ['1234568', 6],
        ['1234569', 6],
        ['1234560', 6],
        ['1234561', 6],
        ['1234562', 6],
        ['1234563', 6],
        ['1234564', 6],
        ['1234565', 6],
    ]
);

it('can validate skus', function ($sku, $isValid) {
    expect(\SchwarzID\ObiUtils\Sku::validate($sku))->toBe($isValid);
})->with([
    ['1234566', true],
    ['3761236', true],
    ['1234567', false],
    ['1234568', false],
    ['1234569', false],
    ['1234560', false],
    ['1234561', false],
    ['1234562', false],
    ['1234563', false],
    ['1234564', false],
    ['1234565', false],
    ['2222222', true],
]);
