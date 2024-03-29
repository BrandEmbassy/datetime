<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use BrandEmbassy\DateTime\Format\NanosecondsToMicrosecondsFormatHelper;
use BrandEmbassy\DateTime\Format\Rfc3339ExtendedFormat;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use function assert;
use function is_array;

/**
 * @final
 */
class DateTimeFromString
{
    /**
     * @throws InvalidDateTimeStringException
     */
    public static function createFromFormat(string $format, string $dateTimeString): DateTimeImmutable
    {
        $dateTime = DateTimeImmutable::createFromFormat($format, $dateTimeString);

        self::assertValidDateTime($dateTime, $format, $dateTimeString);
        assert($dateTime instanceof DateTimeImmutable);

        return $dateTime;
    }


    public static function create(string $dateTimeStringInRfc3339): DateTimeImmutable
    {
        return self::createFromFormat(DateTime::RFC3339, $dateTimeStringInRfc3339);
    }


    public static function createWithMilliseconds(string $dateTimeStringInRfc3339ExtendedString): DateTimeImmutable
    {
        $format = Rfc3339ExtendedFormat::getInputFormat();
        $dateTimeStringInRfc3339ExtendedString = NanosecondsToMicrosecondsFormatHelper::normalizeInputIfNeeded(
            $dateTimeStringInRfc3339ExtendedString,
        );

        return self::createFromFormat($format, $dateTimeStringInRfc3339ExtendedString);
    }


    /**
     * @throws InvalidDateTimeStringException
     */
    public static function createWithTimezoneFromFormat(
        string $format,
        string $dateTimeString,
        DateTimeZone $timezone
    ): DateTimeImmutable {
        $dateTime = DateTimeImmutable::createFromFormat($format, $dateTimeString, $timezone);

        self::assertValidDateTime($dateTime, $format, $dateTimeString);
        assert($dateTime instanceof DateTimeImmutable);

        return $dateTime;
    }


    /**
     * @param DateTimeImmutable|false $dateTime
     *
     * @throws InvalidDateTimeStringException
     */
    private static function assertValidDateTime(
        $dateTime,
        string $format,
        string $originalDateTimeString
    ): void {
        if ($dateTime === false) {
            throw InvalidDateTimeStringException::byNoDatetimeString($format, $originalDateTimeString);
        }

        $lastErrors = DateTimeImmutable::getLastErrors();
        if (is_array($lastErrors) &&
            ($lastErrors['warning_count'] > 0 || $lastErrors['error_count'] > 0)
        ) {
            throw InvalidDateTimeStringException::byValidationErrors(
                $originalDateTimeString,
                $lastErrors['errors'],
                $lastErrors['warnings'],
            );
        }
    }
}
