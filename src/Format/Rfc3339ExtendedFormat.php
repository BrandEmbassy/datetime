<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime\Format;

use DateTime;
use const PHP_VERSION_ID;

final class Rfc3339ExtendedFormat
{
    public static function getOutputFormat(): string
    {
        return DateTime::RFC3339_EXTENDED;
    }


    public static function getInputFormat(): string
    {
        return 'Y-m-d\TH:i:s.uP';
        return PHP_VERSION_ID >= 70300
            ? DateTime::RFC3339_EXTENDED
            : 'Y-m-d\TH:i:s.uP';
    }
}
