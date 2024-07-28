<?php

namespace SchwarzID\ObiUtils\DTO;

readonly class BarcodeData
{
    public function __construct(
        public string $number,
        public string $rawData,
        public ?string $price = null,
    ) {
    }
}
