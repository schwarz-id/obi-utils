<?php

namespace SchwarzID\ObiUtils\DTO;

use SchwarzID\ObiUtils\Support\BarcodeType;

readonly class Barcode
{
    public function __construct(
        public BarcodeType $type,
        public BarcodeData $data,
    ) {}
}
