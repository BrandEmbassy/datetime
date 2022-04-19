<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTimeImmutable;
use InvalidArgumentException;
use function sprintf;

/**
 * @final
 */
class DateTimeFromTimestamp
{
    /**
     * @throws InvalidArgumentException
     */
    public static function create(int $timestamp): DateTimeImmutable
    {
        $dateTime = DateTimeImmutable::createFromFormat('U', (string)$timestamp);

        if (!$dateTime instanceof DateTimeImmutable) {
            throw new InvalidArgumentException(sprintf('Can\'t convert timestamp %d to datetime.', $timestamp));
        }

        return $dateTime;
    }


    /**
     * @throws InvalidArgumentException
     */
    public static function createIncludingMilliseconds(int $milliseconds): DateTimeImmutable
    {
        $timestampWithMilliseconds = sprintf('%.3f', $milliseconds / 1000);
        $dateTime = DateTimeImmutable::createFromFormat('U.u', $timestampWithMilliseconds);

        if (!$dateTime instanceof DateTimeImmutable) {
            throw new InvalidArgumentException(sprintf('Can\'t convert timestamp %d to datetime.', $milliseconds));
        }

        return $dateTime;
    }
}
