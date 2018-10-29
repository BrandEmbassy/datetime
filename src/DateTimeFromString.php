<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use Assert\Assertion;
use Assert\AssertionFailedException;
use DateTimeImmutable;
use DateTimeZone;

final class DateTimeFromString
{

    /**
     * @param string $format
     * @param string $dateTimeString
     * @return DateTimeImmutable
     * @throws AssertionFailedException when date time can't be created from given string
     */
    public static function create(string $format, string $dateTimeString): DateTimeImmutable
    {
        $dateTime = DateTimeImmutable::createFromFormat($format, $dateTimeString);

        return self::assertValidDateTime($dateTime, $format, $dateTimeString);
    }

    /**
     * @param string $format
     * @param string $dateTimeString
     * @param DateTimeZone $timezone
     * @return DateTimeImmutable
     * @throws AssertionFailedException when date time can't be created from given string
     */
    public static function createWithTimezone(
        string $format,
        string $dateTimeString,
        DateTimeZone $timezone
    ): DateTimeImmutable {
        $dateTime = DateTimeImmutable::createFromFormat($format, $dateTimeString, $timezone);

        return self::assertValidDateTime($dateTime, $format, $dateTimeString);
    }

    /**
     * @param DateTimeImmutable|false $dateTime
     * @param string $format
     * @param string $originalDateTimeString
     * @throws AssertionFailedException when given date time can't be created from given string
     */
    private static function assertValidDateTime(
        $dateTime,
        string $format,
        string $originalDateTimeString
    ): DateTimeImmutable {
        Assertion::notSame(
            false,
            $dateTime,
            \sprintf(
                'Can\'t convert %s to datetime using format %s.',
                $originalDateTimeString,
                $format
            )
        );

        return $dateTime;
    }

}
