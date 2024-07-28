<?php

namespace SchwarzID\ObiUtils;

use Exception;
use http\Exception\InvalidArgumentException;
use SchwarzID\ObiUtils\DTO\Barcode;
use SchwarzID\ObiUtils\DTO\BarcodeData;
use SchwarzID\ObiUtils\Exceptions\InvalidGtinLength;
use SchwarzID\ObiUtils\Parser\Sku;
use SchwarzID\ObiUtils\Support\BarcodeType;
use Picqer\Barcode\BarcodeGeneratorJPG;

class ObiBarcodeGenerator
{
    public static function fromGtinAsBase64(string $gtin): ?String
    {
        try {
            $gtin = new Parser\Gtin($gtin);

            $barcodeGenerator = new BarcodeGeneratorJPG();

            $barcodeType = match (strlen($gtin->getNumber())) {
                13 => $barcodeGenerator::TYPE_EAN_13,
                8 => $barcodeGenerator::TYPE_EAN_8,
                default => throw new InvalidGtinLength(),
            };

            $base64Barcode = "data:image/jpeg;base64,";
            $base64Barcode .= base64_encode($barcodeGenerator->getBarcode($gtin->getNumber(), $barcodeType, 8, 120));

            return $base64Barcode;
        } catch (Exception) {

            return null;
        }
    }

    public static function fromSkuAsBase64(string $sku): ?String
    {
        try {
            $sku = new Sku($sku);

            $barcodeGenerator = new BarcodeGeneratorJPG();

            // Construct raw barcode data
            $barcodeData = $sku->getNumberWithoutCheckDigit();
            $barcodeData .= '0000002';
            $barcodeData .= self::calculateItfChecksum($barcodeData);

            $base64Barcode = "data:image/jpeg;base64,";
            $base64Barcode .= base64_encode($barcodeGenerator->getBarcode($barcodeData, $barcodeGenerator::TYPE_INTERLEAVED_2_5, 8, 120));

            return $base64Barcode;
        } catch (Exception) {

            return null;
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function calculateItfChecksum($barcodeWithoutChecksum): int
    {
        if (strlen($barcodeWithoutChecksum) % 2 !== 1) {
            throw new InvalidArgumentException('The length of the barcode passed to ITF::calculateChecksum has to be odd. Did you remove the checksum?');
        }

        $baseNumber = array_map(fn ($digit) => (int) $digit, str_split($barcodeWithoutChecksum));
        $iterator = 1;
        $checksum = 0;

        foreach ($baseNumber as $digit) {
            if ($iterator % 2 === 0) {
                $checksum += $digit;
            } else {
                $checksum += $digit * 3;
            }

            $iterator++;
        }

        return $checksum % 10 === 0
            ? 0
            : 10 - ($checksum % 10);
    }
}
