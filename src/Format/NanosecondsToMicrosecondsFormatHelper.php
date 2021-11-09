<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime\Format;

use function is_string;

final class NanosecondsToMicrosecondsFormatHelper
{
    public const INPUT_WITH_NANOSECONDS_PATTERN = '/^\d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d{7,9}(Z|(\+|\-)[0,1]\d:00)$/';
    private const NANOSECONDS_PATTERN = '/\d{7,9}/';


    public static function trimNanoseconds(string $dateTimeAsStringWithNanoseconds): string
    {
        preg_match(self::NANOSECONDS_PATTERN, $dateTimeAsStringWithNanoseconds, $nanosecondsArray);
        if ($nanosecondsArray === []) {
            return $dateTimeAsStringWithNanoseconds;
        }

        $nanoseconds = current($nanosecondsArray);
        $microseconds = substr($nanoseconds, 0, 6);
        $dateTimeAsString = preg_replace(self::NANOSECONDS_PATTERN, $microseconds, $dateTimeAsStringWithNanoseconds);
        assert(is_string($dateTimeAsString));

        return $dateTimeAsString;
    }
}
