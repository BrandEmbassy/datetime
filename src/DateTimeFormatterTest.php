<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @final
 */
class DateTimeFormatterTest extends TestCase
{
    private const DATETIME_WITHOUT_MILLISECONDS = '2017-05-10T12:13:14+02:00';
    private const DATETIME_WITH_MILLISECONDS = '2017-05-10T12:13:14.000+02:00';


    /**
     * @dataProvider getDateTimeToFormat
     */
    public function testFormat(DateTimeInterface $dateTime): void
    {
        $formattedDateTime = DateTimeFormatter::format($dateTime);

        Assert::assertSame(self::DATETIME_WITHOUT_MILLISECONDS, $formattedDateTime);
    }


    /**
     * @dataProvider getDateTimeToFormat
     */
    public function testFormatWithMilliseconds(DateTimeInterface $dateTime): void
    {
        $formattedDateTime = DateTimeFormatter::formatWithMilliseconds($dateTime);

        Assert::assertSame(self::DATETIME_WITH_MILLISECONDS, $formattedDateTime);
    }


    /**
     * @dataProvider getDateTimeToFormat
     */
    public function testFormatInTimezoneAs(DateTimeInterface $dateTime): void
    {
        $expectedUtcFormat = '2017-05-10T10:13:14+00:00';

        $formattedDateTime = DateTimeFormatter::formatInTimezoneAs(
            $dateTime,
            new DateTimeZone('UTC'),
            DateTime::ATOM,
        );

        Assert::assertSame($expectedUtcFormat, $formattedDateTime);
    }


    /**
     * @dataProvider getDateTimeToFormat
     */
    public function testFormatInTimezone(DateTimeInterface $dateTime): void
    {
        $expectedUtcFormat = '2017-05-10T10:13:14+00:00';

        $formattedDateTime = DateTimeFormatter::formatInTimezone($dateTime, new DateTimeZone('UTC'));

        Assert::assertSame($expectedUtcFormat, $formattedDateTime);
    }


    /**
     * @return DateTimeInterface[][]
     */
    public function getDateTimeToFormat(): array
    {
        return [
            'immutable' => [new DateTimeImmutable(self::DATETIME_WITHOUT_MILLISECONDS)],
            'muttable' => [new DateTime(self::DATETIME_WITHOUT_MILLISECONDS)],
        ];
    }


    public function testFormatTimestamp(): void
    {
        $formattedDateTime = DateTimeFormatter::formatTimestampAs(1496237560, 'Y-m-d');

        Assert::assertSame('2017-05-31', $formattedDateTime);
    }


    public function testFormatTimestampAsAtom(): void
    {
        $formattedDateTime = DateTimeFormatter::formatTimestamp(1496237560);

        Assert::assertSame('2017-05-31T13:32:40+00:00', $formattedDateTime);
    }


    public function testFormatTimestampWithMillis(): void
    {
        $formattedDateTime = DateTimeFormatter::formatTimestampIncludingMilliseconds(1496237560456);

        Assert::assertSame('2017-05-31T13:32:40.456+00:00', $formattedDateTime);
    }


    public function testFormatTimestampInTimezoneAs(): void
    {
        $formattedDateTime = DateTimeFormatter::formatTimestampInTimezoneAs(
            1496237560,
            new DateTimeZone('Europe/Prague'),
            DateTime::ATOM,
        );

        Assert::assertSame('2017-05-31T15:32:40+02:00', $formattedDateTime);
    }


    public function testFormatTimestampInTimezone(): void
    {
        $formattedDateTime = DateTimeFormatter::formatTimestampInTimezone(
            1496237560,
            new DateTimeZone('Europe/Prague'),
        );

        Assert::assertSame('2017-05-31T15:32:40+02:00', $formattedDateTime);
    }


    public function testFormatTimestampWithMillisecondsInTimezone(): void
    {
        $formattedDateTime = DateTimeFormatter::formatTimestampWithMillisecondsInTimezone(
            1496237560456,
            new DateTimeZone('Europe/Prague'),
        );

        Assert::assertSame('2017-05-31T15:32:40.456+02:00', $formattedDateTime);
    }


    public function testConvertToMilliseconds(): void
    {
        $timestampInMilliseconds = DateTimeFormatter::convertToMilliseconds(
            DateTimeFromString::createWithMilliseconds('2020-04-13T22:38:12.123+00:00'),
        );

        Assert::assertSame(1586817492123, $timestampInMilliseconds);
    }
}
