<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTime;
use DateTimeZone;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DateTimeFromStringTest extends TestCase
{

    /**
     * @dataProvider dateTimeToCreateProvider
     * @param string $expectedDateTime
     * @param string $format
     * @param string $dateTimeString
     */
    public function testShouldCreateDateTime(
        string $expectedDateTime,
        string $format,
        string $dateTimeString
    ): void {
        $dateTime = DateTimeFromString::create($format, $dateTimeString);

        $this->assertEquals($expectedDateTime, $dateTime->format(DateTime::ATOM));
    }

    public function dateTimeToCreateProvider(): array
    {
        return [
            ['2017-05-31T13:32:40+00:00', 'U', '1496237560'],
            ['2017-05-10T12:13:14+02:00', DateTime::ATOM, '2017-05-10T12:13:14+02:00'],
        ];
    }

    /**
     * @dataProvider dateTimeWithTimeZoneToCreateProvider
     * @param string $expectedDateTime
     * @param string $format
     * @param string $dateTimeString
     * @param DateTimeZone $timeZone
     */
    public function testShouldCreateDateTimeWithTimezone(
        string $expectedDateTime,
        string $format,
        string $dateTimeString,
        DateTimeZone $timeZone
    ): void {
        $dateTime = DateTimeFromString::createWithTimezone($format, $dateTimeString, $timeZone);

        $this->assertEquals($expectedDateTime, $dateTime->format(DateTime::ATOM));
    }

    public function dateTimeWithTimeZoneToCreateProvider(): array
    {
        return [
            ['2017-05-10T12:13:14+02:00', 'Y-m-d H:i:s', '2017-05-10 12:13:14', new DateTimeZone('Europe/Prague')],
            ['2017-05-10T12:13:14+00:00', 'Y-m-d H:i:s', '2017-05-10 12:13:14', new DateTimeZone('UTC')],
        ];
    }

    /**
     * @dataProvider invalidDataProvider
     * @param string $format
     * @param string $dateTimeString
     */
    public function testShouldThrowExceptionWhenCantCreateDateTime(string $format, string $dateTimeString): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            \sprintf(
                'Can\'t convert %s to datetime using format %s.',
                $dateTimeString,
                $format
            )
        );

        DateTimeFromString::create($format, $dateTimeString);
    }

    /**
     * @dataProvider invalidDataProvider
     * @param string $format
     * @param string $dateTimeString
     */
    public function testShouldThrowExceptionWhenCantCreateDateTimeWithTimeZone(
        string $format,
        string $dateTimeString
    ): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            \sprintf(
                'Can\'t convert %s to datetime using format %s.',
                $dateTimeString,
                $format
            )
        );

        DateTimeFromString::createWithTimezone($format, $dateTimeString, new DateTimeZone('Europe/Prague'));
    }

    public function invalidDataProvider(): array
    {
        return [
            ['', 'U'],
            ['gandalf', 'U'],
            ['-1', 'U'],
            ['0000-00-00 00:00:00', 'Y-m-d H:i:s'],
        ];
    }

}
