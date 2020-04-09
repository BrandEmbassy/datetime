<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use PHPStan\Testing\TestCase;
use PHPUnit\Framework\Assert;

final class DateTimeFormatterTest extends TestCase
{
    public function testFormatAsAtom(): void
    {
        $dateTimeInAtom = '2017-05-10T12:13:14+02:00';
        $formattedDateTime = DateTimeFormatter::formatAsAtom(new DateTimeImmutable($dateTimeInAtom));

        Assert::assertSame($dateTimeInAtom, $formattedDateTime);
    }


    public function testFormatInTimezone(): void
    {
        $pragueDateTimeFormat = '2017-05-10T12:13:14+02:00';
        $expectedUtcFormat = '2017-05-10T10:13:14+00:00';

        $formattedDateTime = DateTimeFormatter::formatInTimezone(
            new DateTimeImmutable($pragueDateTimeFormat),
            new DateTimeZone('UTC'),
            DateTime::ATOM
        );

        Assert::assertSame($expectedUtcFormat, $formattedDateTime);
    }


    public function testFormatInTimezoneAsAtom(): void
    {
        $pragueDateTimeFormat = '2017-05-10T12:13:14+02:00';
        $expectedUtcFormat = '2017-05-10T10:13:14+00:00';

        $formattedDateTime = DateTimeFormatter::formatInTimezoneAsAtom(
            new DateTimeImmutable($pragueDateTimeFormat),
            new DateTimeZone('UTC')
        );

        Assert::assertSame($expectedUtcFormat, $formattedDateTime);
    }


    public function testFormatTimestamp(): void
    {
        $formattedDateTime = DateTimeFormatter::formatTimestamp(1496237560, 'Y-m-d');

        Assert::assertSame('2017-05-31', $formattedDateTime);
    }


    public function testFormatTimestampAsAtom(): void
    {
        $formattedDateTime = DateTimeFormatter::formatTimestampAsAtom(1496237560);

        Assert::assertSame('2017-05-31T13:32:40+00:00', $formattedDateTime);
    }


    public function testFormatTimestampInTimezone(): void
    {
        $formattedDateTime = DateTimeFormatter::formatTimestampInTimezone(
            1496237560,
            new DateTimeZone('Europe/Prague'),
            DateTime::ATOM
        );

        Assert::assertSame('2017-05-31T15:32:40+02:00', $formattedDateTime);
    }


    public function testFormatTimestampInTimezoneAsAtom(): void
    {
        $formattedDateTime = DateTimeFormatter::formatTimestampInTimezoneAsAtom(
            1496237560,
            new DateTimeZone('Europe/Prague')
        );

        Assert::assertSame('2017-05-31T15:32:40+02:00', $formattedDateTime);
    }
}
