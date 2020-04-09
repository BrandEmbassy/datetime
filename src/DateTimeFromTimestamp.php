<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTimeImmutable;
use function assert;
use function sprintf;

final class DateTimeFromTimestamp
{
    public static function create(int $timestamp): DateTimeImmutable
    {
        $dateTime = DateTimeImmutable::createFromFormat('U', (string)$timestamp);

        assert(
            $dateTime instanceof DateTimeImmutable,
            sprintf('Can\'t convert timestamp %s to datetime.', $timestamp)
        );

        return $dateTime;
    }


    public static function createIncludingMilliseconds(int $milliseconds): DateTimeImmutable
    {
        return self::create($milliseconds / 1000);
    }
}
