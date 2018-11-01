<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTime;
use DateTimeZone;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use function sprintf;

class DateTimeFromStringTest extends TestCase
{
    /**
     * @dataProvider dateTimeToCreateProvider
     */
    public function testShouldCreateDateTime(
        string $expectedDateTime,
        string $format,
        string $dateTimeString
    ): void {
        $dateTime = DateTimeFromString::create($format, $dateTimeString);

        self::assertEquals($expectedDateTime, $dateTime->format(DateTime::ATOM));
    }


    /**
     * @return mixed[]
     */
    public function dateTimeToCreateProvider(): array
    {
        return [
            ['2017-05-31T13:32:40+00:00', 'U', '1496237560'],
            ['2017-05-10T12:13:14+02:00', DateTime::ATOM, '2017-05-10T12:13:14+02:00'],
        ];
    }


    /**
     * @dataProvider dateTimeWithTimeZoneToCreateProvider
     */
    public function testShouldCreateDateTimeWithTimezone(
        string $expectedDateTime,
        string $format,
        string $dateTimeString,
        DateTimeZone $timeZone
    ): void {
        $dateTime = DateTimeFromString::createWithTimezone($format, $dateTimeString, $timeZone);

        self::assertEquals($expectedDateTime, $dateTime->format(DateTime::ATOM));
    }


    /**
     * @return mixed[]
     */
    public function dateTimeWithTimeZoneToCreateProvider(): array
    {
        return [
            ['2017-05-10T12:13:14+02:00', 'Y-m-d H:i:s', '2017-05-10 12:13:14', new DateTimeZone('Europe/Prague')],
            ['2017-05-10T12:13:14+00:00', 'Y-m-d H:i:s', '2017-05-10 12:13:14', new DateTimeZone('UTC')],
        ];
    }


    /**
     * @dataProvider invalidDataProvider
     */
    public function testShouldThrowExceptionWhenCantCreateDateTime(string $format, string $dateTimeString): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Can\'t convert %s to datetime using format %s.',
                $dateTimeString,
                $format
            )
        );

        DateTimeFromString::create($format, $dateTimeString);
    }


    /**
     * @dataProvider invalidDataProvider
     */
    public function testShouldThrowExceptionWhenCantCreateDateTimeWithTimeZone(
        string $format,
        string $dateTimeString
    ): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Can\'t convert %s to datetime using format %s.',
                $dateTimeString,
                $format
            )
        );

        DateTimeFromString::createWithTimezone($format, $dateTimeString, new DateTimeZone('Europe/Prague'));
    }


    /**
     * @return mixed[]
     */
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
