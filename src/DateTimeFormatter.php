<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTimeImmutable;
use DateTimeZone;

final class DateTimeFormatter
{
    public static function formatInTimezone(
        DateTimeImmutable $dateTimeImmutable,
        DateTimeZone $dateTimeZone,
        string $format
    ): string {
        $dateTimeImmutableInTimezone = $dateTimeImmutable->setTimezone($dateTimeZone);

        return $dateTimeImmutableInTimezone->format($format);
    }


    public static function formatTimestampInTimezone(
        int $timestamp,
        DateTimeZone $dateTimeZone,
        string $format
    ): string {
        $dateTimeImmutable = DateTimeFromTimestamp::create($timestamp);
        $dateTimeImmutableInTimezone = $dateTimeImmutable->setTimezone($dateTimeZone);

        return $dateTimeImmutableInTimezone->format($format);
    }
}
