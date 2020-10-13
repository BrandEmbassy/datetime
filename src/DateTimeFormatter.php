<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use BrandEmbassy\DateTime\Format\Rfc3339ExtendedFormat;
use DateTime;
use DateTimeInterface;
use DateTimeZone;
use function assert;
use function method_exists;

final class DateTimeFormatter
{
    public static function formatAs(DateTimeInterface $dateTime, string $format): string
    {
        return $dateTime->format($format);
    }


    public static function formatTimestampAs(int $timestamp, string $format): string
    {
        $dateTimeImmutable = DateTimeFromTimestamp::create($timestamp);

        return self::formatAs($dateTimeImmutable, $format);
    }


    public static function format(DateTimeInterface $dateTime): string
    {
        return self::formatAs($dateTime, DateTime::RFC3339);
    }


    public static function formatWithMilliseconds(DateTimeInterface $dateTime): string
    {
        return self::formatAs($dateTime, Rfc3339ExtendedFormat::getOutputFormat());
    }


    public static function formatTimestamp(int $timestamp): string
    {
        $dateTimeImmutable = DateTimeFromTimestamp::create($timestamp);

        return self::format($dateTimeImmutable);
    }


    public static function formatTimestampIncludingMilliseconds(int $timestampIncludingMilliseconds): string
    {
        $dateTimeImmutable = DateTimeFromTimestamp::createIncludingMilliseconds($timestampIncludingMilliseconds);

        return self::formatWithMilliseconds($dateTimeImmutable);
    }


    public static function formatInTimezoneAs(
        DateTimeInterface $dateTime,
        DateTimeZone $dateTimeZone,
        string $format
    ): string {
        assert(method_exists($dateTime, 'setTimezone'));

        return self::formatAs($dateTime->setTimezone($dateTimeZone), $format);
    }


    public static function formatInTimezone(DateTimeInterface $dateTime, DateTimeZone $dateTimeZone): string
    {
        assert(method_exists($dateTime, 'setTimezone'));

        return self::format($dateTime->setTimezone($dateTimeZone));
    }


    public static function formatInTimezoneWithMilliseconds(
        DateTimeInterface $dateTime,
        DateTimeZone $dateTimeZone
    ): string {
        assert(method_exists($dateTime, 'setTimezone'));

        return self::formatWithMilliseconds($dateTime->setTimezone($dateTimeZone));
    }


    public static function formatTimestampInTimezoneAs(
        int $timestamp,
        DateTimeZone $dateTimeZone,
        string $format
    ): string {
        $dateTimeImmutable = DateTimeFromTimestamp::create($timestamp);

        return self::formatInTimezoneAs($dateTimeImmutable, $dateTimeZone, $format);
    }


    public static function formatTimestampInTimezone(int $timestamp, DateTimeZone $dateTimeZone): string
    {
        $dateTimeImmutable = DateTimeFromTimestamp::create($timestamp);

        return self::formatInTimezone($dateTimeImmutable, $dateTimeZone);
    }


    public static function formatTimestampWithMillisecondsInTimezone(
        int $timestampIncludingMilliseconds,
        DateTimeZone $dateTimeZone
    ): string {
        $dateTimeImmutable = DateTimeFromTimestamp::createIncludingMilliseconds($timestampIncludingMilliseconds);

        return self::formatInTimezoneWithMilliseconds($dateTimeImmutable, $dateTimeZone);
    }
}
