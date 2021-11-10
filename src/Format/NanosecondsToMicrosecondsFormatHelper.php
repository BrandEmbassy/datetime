<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime\Format;

use function array_shift;
use function implode;
use function preg_match;

final class NanosecondsToMicrosecondsFormatHelper
{
    private const MICROSECONDS_AND_TIMEZONE_PATTERN = '/^(^\d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d{6})\d*(Z|(?:\+|\-)[0,1]\d:00)$/';


    public static function normalizeInputIfNeeded(string $dateTimeString): string
    {
        if (preg_match(self::MICROSECONDS_AND_TIMEZONE_PATTERN, $dateTimeString, $dateTimeParts) === 1) {
            array_shift($dateTimeParts);

            return implode('', $dateTimeParts);
        }

        return $dateTimeString;
    }
}
