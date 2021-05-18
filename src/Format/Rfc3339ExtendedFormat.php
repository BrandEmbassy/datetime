<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime\Format;

use DateTime;

final class Rfc3339ExtendedFormat
{
    public static function getOutputFormat(): string
    {
        return DateTime::RFC3339_EXTENDED;
    }


    public static function getInputFormat(): string
    {
        return 'Y-m-d\TH:i:s.uP';
    }
}
