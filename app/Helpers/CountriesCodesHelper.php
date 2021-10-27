<?php

namespace App\Helpers;

class CountriesCodesHelper
{
    const DATA_SOURCE_PATH = __DIR__ . '/../../resources/data/iso3.json';

    private static array $codes = [];

    public static function iso2ToIso3(?string $iso2): ?string
    {
        if (empty($iso2)) {
            return $iso2;
        }

        if (empty(self::$codes)) {
            self::loadCodes();
        }

        $iso2 = strtoupper($iso2);
        return self::$codes[$iso2] ?? '';
    }

    private static function loadCodes()
    {
        self::$codes = json_decode(
            file_get_contents(self::DATA_SOURCE_PATH),
            true
        );
    }
}
