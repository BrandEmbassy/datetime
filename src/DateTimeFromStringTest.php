<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTime;
use DateTimeZone;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class DateTimeFromStringTest extends TestCase
{
    /**
     * @dataProvider dateTimeToCreateProvider
     */
    public function testCreateDateTime(
        string $expectedDateTime,
        string $format,
        string $dateTimeString
    ): void {
        $dateTime = DateTimeFromString::create($format, $dateTimeString);

        Assert::assertSame($expectedDateTime, $dateTime->format(DateTime::ATOM));
    }


    /**
     * @return mixed[]
     */
    public function dateTimeToCreateProvider(): array
    {
        return [
            'Unix timestamp' => [
                'expectedDateTime' => '2017-05-31T13:32:40+00:00',
                'format' => 'U',
                'dateTimeString' => '1496237560',
            ],
            'Negative Unix timestamp' => [
                'expectedDateTime' => '1969-12-31T23:59:59+00:00',
                'format' => 'U',
                'dateTimeString' => '-1',
            ],
            'ISO 8601 with TZ designators ±hh:mm' => [
                'expectedDateTime' => '2017-05-10T12:13:14+05:00',
                'format' => DateTime::ATOM,
                'dateTimeString' => '2017-05-10T12:13:14+05:00',
            ],
            'ISO 8601 with TZ designator Z' => [
                'expectedDateTime' => '2017-05-10T12:13:14+00:00',
                'format' => DateTime::ATOM,
                'dateTimeString' => '2017-05-10T12:13:14Z',
            ],
            'ISO 8601 with TZ designator ±hhmm' => [
                'expectedDateTime' => '2017-05-10T12:13:14+08:00',
                'format' => DateTime::ATOM,
                'dateTimeString' => '2017-05-10T12:13:14+0800',
            ],
            'ISO 8601 with TZ designator ±hh' => [
                'expectedDateTime' => '2017-05-10T12:13:14-03:00',
                'format' => DateTime::ATOM,
                'dateTimeString' => '2017-05-10T12:13:14-03',
            ],
        ];
    }


    public function testCreateDateTimeFromAtom(): void
    {
        $dateTimeInAtom = '2017-05-10T12:13:14+02:00';

        $dateTime = DateTimeFromString::createFromAtom($dateTimeInAtom);
        Assert::assertSame($dateTimeInAtom, $dateTime->format(DateTime::ATOM));
    }


    /**
     * @dataProvider dateTimeWithTimeZoneToCreateProvider
     */
    public function testCreateDateTimeWithTimezone(
        string $expectedDateTime,
        string $format,
        string $dateTimeString,
        DateTimeZone $timeZone
    ): void {
        $dateTime = DateTimeFromString::createWithTimezone($format, $dateTimeString, $timeZone);

        Assert::assertSame($expectedDateTime, $dateTime->format(DateTime::ATOM));
    }


    /**
     * @return mixed[]
     */
    public function dateTimeWithTimeZoneToCreateProvider(): array
    {
        return [
            [
                'expectedDateTime' => '2017-05-10T12:13:14+02:00',
                'format' => 'Y-m-d H:i:s',
                'dateTimeString' => '2017-05-10 12:13:14',
                'timeZone' => new DateTimeZone('Europe/Prague'),
            ],
            [
                'expectedDateTime' => '2017-05-10T12:13:14+00:00',
                'format' => 'Y-m-d H:i:s',
                'dateTimeString' => '2017-05-10 12:13:14',
                'timeZone' => new DateTimeZone('UTC'),
            ],
        ];
    }


    /**
     * @dataProvider invalidDataProvider
     */
    public function testThrowExceptionWhenCantCreateDateTime(
        string $expectedExceptionMessage,
        string $format,
        string $dateTimeString
    ): void {
        $this->expectException(InvalidDateTimeStringException::class);
        $this->expectExceptionMessage($expectedExceptionMessage);

        DateTimeFromString::create($format, $dateTimeString);
    }


    /**
     * @dataProvider invalidDataProvider
     */
    public function testThrowExceptionWhenCantCreateDateTimeWithTimeZone(
        string $expectedExceptionMessage,
        string $format,
        string $dateTimeString
    ): void {
        $this->expectException(InvalidDateTimeStringException::class);
        $this->expectExceptionMessage($expectedExceptionMessage);

        DateTimeFromString::createWithTimezone($format, $dateTimeString, new DateTimeZone('Europe/Prague'));
    }


    /**
     * @return mixed[]
     */
    public function invalidDataProvider(): array
    {
        return [
            'Empty unix timestamp' => [
                'expectedExceptionMessage' => "Can't convert '' to datetime using format U.",
                'format' => 'U',
                'dateTimeString' => '',
            ],
            'Non-digit unix timestamp' => [
                'expectedExceptionMessage' => "Can't convert 'gandalf' to datetime using format U.",
                'format' => 'U',
                'dateTimeString' => 'gandalf',
            ],
            'Classic datetime with zeros' => [
                'expectedExceptionMessage' =>
                    "Datetime '0000-00-00 00:00:00' cannot be considered as fully valid string.",
                'format' => 'Y-m-d H:i:s',
                'dateTimeString' => '0000-00-00 00:00:00',
            ],
            'ISO 8601 with zeros' => [
                'expectedExceptionMessage' =>
                    "Datetime '0000-00-00T00:00:00+00:00' cannot be considered as fully valid string.",
                'format' => DateTime::ATOM,
                'dateTimeString' => '0000-00-00T00:00:00+00:00',
            ],
            'ISO 8601 with invalid day in month' => [
                'expectedExceptionMessage' =>
                    "Datetime '2020-11-31T12:13:14+02:00' cannot be considered as fully valid string.",
                'format' => DateTime::ATOM,
                'dateTimeString' => '2020-11-31T12:13:14+02:00',
            ],
            'ISO 8601 with invalid month' => [
                'expectedExceptionMessage' => "Datetime '2020-13-05T12:13:14+02:00' cannot be considered as fully valid string.",
                'format' => DateTime::ATOM,
                'dateTimeString' => '2020-13-05T12:13:14+02:00',
            ],
        ];
    }
}
