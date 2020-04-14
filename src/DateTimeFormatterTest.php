<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use PHPStan\Testing\TestCase;
use PHPUnit\Framework\Assert;

final class DateTimeFormatterTest extends TestCase
{
    private const DATETIME_IN_ATOM = '2017-05-10T12:13:14+02:00';


    /**
     * @dataProvider getDateTimeToFormat
     */
    public function testFormatAsAtom(DateTimeInterface $dateTime): void
    {
        $formattedDateTime = DateTimeFormatter::formatAsAtom($dateTime);

        Assert::assertSame(self::DATETIME_IN_ATOM, $formattedDateTime);
    }


    /**
     * @dataProvider getDateTimeToFormat
     */
    public function testFormatInTimezone(DateTimeInterface $dateTime): void
    {
        $expectedUtcFormat = '2017-05-10T10:13:14+00:00';

        $formattedDateTime = DateTimeFormatter::formatInTimezone(
            $dateTime,
            new DateTimeZone('UTC'),
            DateTime::ATOM
        );

        Assert::assertSame($expectedUtcFormat, $formattedDateTime);
    }


    /**
     * @dataProvider getDateTimeToFormat
     */
    public function testFormatInTimezoneAsAtom(DateTimeInterface $dateTime): void
    {
        $expectedUtcFormat = '2017-05-10T10:13:14+00:00';

        $formattedDateTime = DateTimeFormatter::formatInTimezoneAsAtom($dateTime, new DateTimeZone('UTC'));

        Assert::assertSame($expectedUtcFormat, $formattedDateTime);
    }


    /**
     * @return DateTimeInterface[][]
     */
    public function getDateTimeToFormat(): array
    {
        return [
            'immutable' => [new DateTimeImmutable(self::DATETIME_IN_ATOM)],
            'muttable' => [new DateTime(self::DATETIME_IN_ATOM)],
        ];
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
