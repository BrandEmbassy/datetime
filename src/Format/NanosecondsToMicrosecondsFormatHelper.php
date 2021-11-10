<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime\Format;

use function array_shift;
use function implode;
use function preg_match;

final class NanosecondsToMicrosecondsFormatHelper
{
    private const INPUT_WITH_NANOSECONDS_PATTERN = '/^\d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d{7,9}(Z|(\+|\-)[0,1]\d:00)$/';
    private const MICROSECONDS_AND_TIMEZONE_PATTERN = '/^(^\d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d{6})\d{1,3}(Z|(?:\+|\-)[0,1]\d:00)$/';


    public static function normalizeInputIfNeeded(string $dateTimeAsStringWithNanoseconds): string
    {
        if (preg_match(self::INPUT_WITH_NANOSECONDS_PATTERN, $dateTimeAsStringWithNanoseconds) === false) {
            return $dateTimeAsStringWithNanoseconds;
        }

        preg_match(self::MICROSECONDS_AND_TIMEZONE_PATTERN, $dateTimeAsStringWithNanoseconds, $truncatedParts);
        if ($truncatedParts === []) {
            return $dateTimeAsStringWithNanoseconds;
        }

        array_shift($truncatedParts);

        return implode('', $truncatedParts);
    }
}
