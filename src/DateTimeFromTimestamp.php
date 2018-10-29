<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use Assert\Assertion;
use DateTimeImmutable;

final class DateTimeFromTimestamp
{

    public static function create(int $timestamp): DateTimeImmutable
    {
        $dateTime = DateTimeImmutable::createFromFormat('U', (string)$timestamp);

        Assertion::notSame(
            false,
            $dateTime,
            \sprintf('Can\'t convert timestamp %s to datetime.', $timestamp)
        );

        return $dateTime;
    }

}
