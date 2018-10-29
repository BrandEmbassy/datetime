<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

class StringFromNowTest extends TestCase
{

    public function testShouldReturnCorrectStringForTimezone(): void
    {
        $dateTimeZone = new DateTimeZone('Europe/Prague');
        $dateTime = new DateTimeImmutable('2011-01-01 22:26:03');

        $dateTimeImmutableFactory = new FrozenDateTimeImmutableFactory($dateTime);
        $stringFromNow = new StringFromNow(new DateTimeFormatter(), $dateTimeImmutableFactory);

        $formattedDateTime = $stringFromNow->formatNowInTimezone($dateTimeZone, DateTime::ATOM);

        $this->assertSame('2011-01-01T23:26:03+01:00', $formattedDateTime);
    }

}
