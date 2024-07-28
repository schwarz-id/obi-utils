<?php

namespace SchwarzID\ObiUtils\Support;

enum BarcodeType: string
{
    case Interleaved2of5 = 'I25';
    case Ean13 = 'EAN13';
    case Ean8 = 'EAN8';
}
