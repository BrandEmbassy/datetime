<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use function assert;
use function method_exists;

final class DateTimeFormatter
{
    public static function format(DateTimeInterface $dateTime, string $format): string
    {
        return $dateTime->format($format);
    }


    public static function formatTimestamp(int $timestamp, string $format): string
    {
        $dateTimeImmutable = DateTimeFromTimestamp::create($timestamp);

        return self::format($dateTimeImmutable, $format);
    }


    public static function formatAsAtom(DateTimeInterface $dateTime): string
    {
        return self::format($dateTime, DateTime::ATOM);
    }


    public static function formatTimestampAsAtom(int $timestamp): string
    {
        $dateTimeImmutable = DateTimeFromTimestamp::create($timestamp);

        return self::formatAsAtom($dateTimeImmutable);
    }


    public static function formatInTimezone(
        DateTimeInterface $dateTime,
        DateTimeZone $dateTimeZone,
        string $format
    ): string {
        assert(method_exists($dateTime, 'setTimezone'));

        return self::format($dateTime->setTimezone($dateTimeZone), $format);
    }


    public static function formatInTimezoneAsAtom(DateTimeInterface $dateTime, DateTimeZone $dateTimeZone): string
    {
        assert(method_exists($dateTime, 'setTimezone'));

        return self::formatAsAtom($dateTime->setTimezone($dateTimeZone));
    }


    public static function formatTimestampInTimezone(
        int $timestamp,
        DateTimeZone $dateTimeZone,
        string $format
    ): string {
        $dateTimeImmutable = DateTimeFromTimestamp::create($timestamp);

        return self::formatInTimezone($dateTimeImmutable, $dateTimeZone, $format);
    }


    public static function formatTimestampInTimezoneAsAtom(int $timestamp, DateTimeZone $dateTimeZone): string
    {
        $dateTimeImmutable = DateTimeFromTimestamp::create($timestamp);

        return self::formatInTimezoneAsAtom($dateTimeImmutable, $dateTimeZone);
    }
}
