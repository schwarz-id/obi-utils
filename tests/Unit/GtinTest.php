<?php

use SchwarzID\ObiUtils\Facades\ObiUtils;

it('does not accept gtin with an invalid length', function ($gtin) {
    new \SchwarzID\ObiUtils\Parser\Gtin($gtin);
})
    ->with(['2345678', '123456', '12', '42349324823094802348092348230423', '', '1'])
    ->throws(\SchwarzID\ObiUtils\Exceptions\InvalidGtinLength::class);

it('does not accept gtin with non-numeric characters', function ($gtin) {
    new \SchwarzID\ObiUtils\Parser\Gtin($gtin);
})
    ->with([
        '123456A123123', '123456B123123', '12C3456123123', '1231.21123123', '1231,51123123',
        '123456A1', '123456B1', '12C34561', '1231.211', '1231,511',
    ])
    ->throws(\SchwarzID\ObiUtils\Exceptions\NonNumericGtin::class);

it('does not accept gtin with an invalid checksum', function ($gtin) {
    new \SchwarzID\ObiUtils\Parser\Gtin($gtin);
})
    ->with([
        '2106278358610', '2106278358611', '2106278358612', '2106278358613', '2106278358614', '2106278358615', '2106278358616', '2106278358617', '2106278358618',
        '90311010', '90311011', '90311012', '90311013', '90311014', '90311015', '90311016', '90311018', '90311019',
    ])
    ->throws(\SchwarzID\ObiUtils\Exceptions\InvalidGtinCheckDigit::class);

it('accepts valid gtin as string or integer', function ($gtin) {
    $gtinObj = new \SchwarzID\ObiUtils\Parser\Gtin($gtin);

    expect($gtinObj->getNumber())->toBe((string) $gtinObj);
})->with(['2106278358619', 2106278358619, '90311017', 90311017]);

it('accepts valid gtins', function ($gtin) {
    $gtinObj = new \SchwarzID\ObiUtils\Parser\Gtin($gtin);

    expect($gtinObj->getNumber())->toBe($gtin);
})->with(['2106278358619', '4007872227357', '90311017']);

it('can be cast to string', function ($gtin) {
    $gtinObj = new \SchwarzID\ObiUtils\Parser\Gtin($gtin);

    expect((string) $gtinObj)->toBe($gtin);
})->with(['2106278358619', '4007872227357', '90311017']);

it('can return the check digit and number with out check digit', function ($gtin) {
    $gtinObj = new \SchwarzID\ObiUtils\Parser\Gtin($gtin);

    expect($gtinObj->getCheckDigit())->toBe((int) substr($gtin, -1))
        ->and($gtinObj->getNumberWithoutCheckDigit())->toBe(substr($gtin, 0, -1));
})->with(['2106278358619', '4007872227357', '90311017']);

it('can force accept gtin13 with an invalid check digit and return the valid check digit', function ($invalidGtin, $validCheckDigit) {
    $gtinObj = new \SchwarzID\ObiUtils\Parser\Gtin($invalidGtin, throwOnInvalidCheckDigit: false);

    expect($gtinObj->getCheckDigit())->toBe($validCheckDigit);
})->with(
    [
        ['2106278358610', 9],
        ['2106278358611', 9],
        ['2106278358612', 9],
        ['2106278358613', 9],
        ['2106278358614', 9],
        ['90311010', 7],
        ['90311011', 7],
        ['90311012', 7],
        ['90311013', 7],
        ['90311014', 7],
    ]
);

it('can validate gtin13s', function ($gtin13, $isValid) {
    expect(ObiUtils::gtin()->validate($gtin13))->toBe($isValid);
})->with([
    ['2106278358619', true],
    ['4007872227357', true],
    ['4007872227351', false],
    ['90311017', true],
    ['90311018', false],
    ['90311019', false],
    ['90311010', false],
    ['90311011', false],
    ['90311012', false],
    ['90311013', false],
    ['90311014', false],
    ['90311015', false],
    ['90311016', false],
    ['4007872227358', false],
    ['4007872227359', false],
    ['4007872227350', false],
    ['8806094373486', true],
]);
