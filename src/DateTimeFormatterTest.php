<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

class DateTimeFormatterTest extends TestCase
{
    /**
     * @dataProvider timestampDataProvider
     */
    public function testFormatTimestampInTimezone(
        int $timestamp,
        DateTimeZone $dateTimeZone,
        string $expectedOutput
    ): void {
        self::assertEquals(
            $expectedOutput,
            DateTimeFormatter::formatTimestampInTimezone($timestamp, $dateTimeZone, DateTime::ATOM)
        );
    }


    /**
     * @dataProvider dateTimeImmutableDataProvider
     */
    public function testFormatInTimezone(
        DateTimeImmutable $dateTimeImmutable,
        DateTimeZone $dateTimeZone,
        string $expectedOutput
    ): void {
        self::assertEquals(
            $expectedOutput,
            DateTimeFormatter::formatInTimezone($dateTimeImmutable, $dateTimeZone, DateTime::ATOM)
        );
    }


    /**
     * @return mixed[]
     */
    public function timestampDataProvider(): array
    {
        return [
            [0, new DateTimeZone('UTC'), '1970-01-01T00:00:00+00:00'],
            [1000000000, new DateTimeZone('UTC'), '2001-09-09T01:46:40+00:00'],
            [1541088210, new DateTimeZone('UTC'), '2018-11-01T16:03:30+00:00'],
            [0, new DateTimeZone('Europe/Moscow'), '1970-01-01T03:00:00+03:00'],
            [1000000000, new DateTimeZone('Europe/Moscow'), '2001-09-09T05:46:40+04:00'],
            [1541088210, new DateTimeZone('Europe/Moscow'), '2018-11-01T19:03:30+03:00'],
        ];
    }


    /**
     * @return mixed[]
     */
    public function dateTimeImmutableDataProvider(): array
    {
        return [
            [
                new DateTimeImmutable('2001-09-09T01:46:40+00:00'),
                new DateTimeZone('Europe/Moscow'),
                '2001-09-09T05:46:40+04:00',
            ],
            [
                new DateTimeImmutable('2001-09-09T01:46:40+00:00'),
                new DateTimeZone('Europe/Prague'),
                '2001-09-09T03:46:40+02:00',
            ],
            [
                new DateTimeImmutable('2001-09-09T01:46:40+00:00'),
                new DateTimeZone('America/Toronto'),
                '2001-09-08T21:46:40-04:00',
            ],
        ];
    }
}
