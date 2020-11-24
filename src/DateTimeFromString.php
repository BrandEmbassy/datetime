<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use function sprintf;

final class DateTimeFromString
{
    public static function create(string $format, string $dateTimeString): DateTimeImmutable
    {
        $dateTime = DateTimeImmutable::createFromFormat($format, $dateTimeString);

        return self::assertValidDateTime($dateTime, $format, $dateTimeString);
    }


    public static function createFromAtom(string $dateTimeAtomString): DateTimeImmutable
    {
        return self::create(DateTime::ATOM, $dateTimeAtomString);
    }


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
     *
     * @throws InvalidArgumentException
     */
    private static function assertValidDateTime(
        $dateTime,
        string $format,
        string $originalDateTimeString
    ): DateTimeImmutable {
        if ($dateTime === false || $dateTime->format($format) !== $originalDateTimeString) {
            $message = sprintf(
                'Can\'t convert %s to datetime using format %s.',
                $originalDateTimeString,
                $format
            );

            throw new InvalidArgumentException($message);
        }

        return $dateTime;
    }
}
