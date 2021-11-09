<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime\Format;

use function assert;
use function current;
use function is_string;
use function preg_match;
use function preg_replace;
use function substr;

final class NanosecondsToMicrosecondsFormatHelper
{
    public const INPUT_WITH_NANOSECONDS_PATTERN = '/^\d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d{7,9}(Z|(\+|\-)[0,1]\d:00)$/';
    private const NANOSECONDS_PATTERN = '/\d{7,9}/';


    public static function normalizeInputIfNeeded(string $dateTimeAsStringWithNanoseconds): string
    {
        if (preg_match(self::INPUT_WITH_NANOSECONDS_PATTERN, $dateTimeAsStringWithNanoseconds) === false) {
            return $dateTimeAsStringWithNanoseconds;
        }

        preg_match(self::NANOSECONDS_PATTERN, $dateTimeAsStringWithNanoseconds, $nanosecondsArray);
        if ($nanosecondsArray === []) {
            return $dateTimeAsStringWithNanoseconds;
        }

        $nanoseconds = current($nanosecondsArray);
        $microseconds = substr($nanoseconds, 0, 6);
        $dateTimeAsStringTrimmed = preg_replace(
            self::NANOSECONDS_PATTERN,
            $microseconds,
            $dateTimeAsStringWithNanoseconds
        );
        assert(is_string($dateTimeAsStringTrimmed));

        return $dateTimeAsStringTrimmed;
    }
}
