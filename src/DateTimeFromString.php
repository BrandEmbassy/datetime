<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use function assert;
use function is_array;

final class DateTimeFromString
{
    /**
     * @throws InvalidDateTimeStringException
     */
    public static function create(string $format, string $dateTimeString): DateTimeImmutable
    {
        $dateTime = DateTimeImmutable::createFromFormat($format, $dateTimeString);

        self::assertValidDateTime($dateTime, $format, $dateTimeString);
        assert($dateTime instanceof DateTimeImmutable);

        return $dateTime;
    }


    /**
     * @throws InvalidDateTimeStringException
     */
    public static function createFromAtom(string $dateTimeAtomString): DateTimeImmutable
    {
        return self::create(DateTime::ATOM, $dateTimeAtomString);
    }


    /**
     * @throws InvalidDateTimeStringException
     */
    public static function createWithTimezone(
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
                $lastErrors['warnings']
            );
        }
    }
}
