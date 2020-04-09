<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;

final class DateTimeFormatter
{
    public static function format(DateTimeImmutable $dateTimeImmutable, string $format): string
    {
        return $dateTimeImmutable->format($format);
    }


    public static function formatTimestamp(int $timestamp, string $format): string
    {
        $dateTimeImmutable = DateTimeFromTimestamp::create($timestamp);

        return self::format($dateTimeImmutable, $format);
    }


    public static function formatAsAtom(DateTimeImmutable $dateTime): string
    {
        return self::format($dateTime, DateTime::ATOM);
    }


    public static function formatTimestampAsAtom(int $timestamp): string
    {
        $dateTimeImmutable = DateTimeFromTimestamp::create($timestamp);

        return self::formatAsAtom($dateTimeImmutable);
    }


    public static function formatInTimezone(
        DateTimeImmutable $dateTimeImmutable,
        DateTimeZone $dateTimeZone,
        string $format
    ): string {
        return self::format($dateTimeImmutable->setTimezone($dateTimeZone), $format);
    }


    public static function formatInTimezoneAsAtom(DateTimeImmutable $dateTime, DateTimeZone $dateTimeZone): string
    {
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
