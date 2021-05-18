<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use BrandEmbassy\DateTime\Format\Rfc3339ExtendedFormat;
use DateTime;
use DateTimeZone;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use function sprintf;

final class DateTimeFromStringTest extends TestCase
{
    /**
     * @dataProvider dateTimeInFormatProvider
     */
    public function testCreateFromFormat(
        string $expectedDateTime,
        string $format,
        string $dateTimeString
    ): void {
        $rfcFormat = Rfc3339ExtendedFormat::getOutputFormat();

        $dateTime = DateTimeFromString::createFromFormat($format, $dateTimeString);

        Assert::assertSame($expectedDateTime, $dateTime->format($rfcFormat));
    }


    /**
     * @return mixed[]
     */
    public function dateTimeInFormatProvider(): array
    {
        $rfcFormat = Rfc3339ExtendedFormat::getInputFormat();

        return [
            'Unix timestamp' => [
                'expectedDateTime' => '2017-05-31T13:32:40.000+00:00',
                'format' => 'U',
                'dateTimeString' => '1496237560',
            ],
            'Negative Unix timestamp' => [
                'expectedDateTime' => '1969-12-31T23:59:59.000+00:00',
                'format' => 'U',
                'dateTimeString' => '-1',
            ],
            'ISO 8601 with TZ designators ±hh:mm' => [
                'expectedDateTime' => '2017-05-10T12:13:14.000+05:00',
                'format' => DateTime::ATOM,
                'dateTimeString' => '2017-05-10T12:13:14+05:00',
            ],
            'ISO 8601 with TZ designator Z' => [
                'expectedDateTime' => '2017-05-10T12:13:14.000+00:00',
                'format' => DateTime::ATOM,
                'dateTimeString' => '2017-05-10T12:13:14Z',
            ],
            'ISO 8601 with TZ designator ±hhmm' => [
                'expectedDateTime' => '2017-05-10T12:13:14.000+08:00',
                'format' => DateTime::ATOM,
                'dateTimeString' => '2017-05-10T12:13:14+0800',
            ],
            'ISO 8601 with TZ designator ±hh' => [
                'expectedDateTime' => '2017-05-10T12:13:14.000-03:00',
                'format' => DateTime::ATOM,
                'dateTimeString' => '2017-05-10T12:13:14-03',
            ],
            'RFC3339 with milliseconds' => [
                'expectedDateTime' => '2017-05-10T12:13:14.314+00:00',
                'format' => $rfcFormat,
                'dateTimeString' => '2017-05-10T12:13:14.314Z',
            ],
        ];
    }


    /**
     * @dataProvider validDateTimeProvider
     */
    public function testCreateDateTime(string $expectedDateTimeString, string $dateTimeString): void
    {
        $dateTime = DateTimeFromString::create($dateTimeString);

        Assert::assertSame($expectedDateTimeString, $dateTime->format(DateTime::RFC3339_EXTENDED));
    }


    /**
     * @return array<string, array<string, string|bool>>
     */
    public function validDateTimeProvider(): array
    {
        return [
            'TZ +2h without millis' => [
                'expectedDateTimeString' => '2017-05-10T12:13:14.000+02:00',
                'dateTimeString' => '2017-05-10T12:13:14+02:00',
            ],
            'TZ -2h without millis' => [
                'expectedDateTimeString' => '2017-05-10T12:13:14.000-02:00',
                'dateTimeString' => '2017-05-10T12:13:14-02:00',
            ],
            'UTC without millis' => [
                'expectedDateTimeString' => '2017-05-10T12:13:14.000+00:00',
                'dateTimeString' => '2017-05-10T12:13:14Z',
            ],
        ];
    }


    /**
     * @dataProvider validDateTimeWithMillisecondsProvider
     */
    public function testCreateDateTimeWithMilliseconds(string $expectedDateTimeString, string $dateTimeString): void
    {
        $dateTime = DateTimeFromString::createWithMilliseconds($dateTimeString);

        Assert::assertSame($expectedDateTimeString, $dateTime->format(DateTime::RFC3339_EXTENDED));
    }


    /**
     * @return array<string, array<string, string|bool>>
     */
    public function validDateTimeWithMillisecondsProvider(): array
    {
        return [
            'TZ +2h with millis' => [
                'expectedDateTimeString' => '2017-05-10T12:13:14.345+02:00',
                'dateTimeString' => '2017-05-10T12:13:14.345+02:00',
            ],
            'TZ -2h with millis' => [
                'expectedDateTimeString' => '2017-05-10T12:13:14.345-02:00',
                'dateTimeString' => '2017-05-10T12:13:14.345-02:00',
            ],
            'UTC with millis' => [
                'expectedDateTimeString' => '2017-05-10T12:13:14.222+00:00',
                'dateTimeString' => '2017-05-10T12:13:14.222Z',
            ],
            'UTC with many millis' => [
                'expectedDateTimeString' => '2021-05-10T10:57:27.234+00:00',
                'dateTimeString' => '2021-05-10T10:57:27.234821Z',
            ],
            'Zero millis' => [
                'expectedDateTimeString' => '2017-05-10T12:13:14.000+00:00',
                'dateTimeString' => '2017-05-10T12:13:14.000+00:00',
            ],
        ];
    }


    public function testThrowExceptionWhenCannotCreateDateTime(): void
    {
        $this->expectException(InvalidDateTimeStringException::class);
        $this->expectExceptionMessage(
            "Can't convert '2020-12-05T02:50:16.123+03:00' to datetime using format Y-m-d\TH:i:sP."
        );

        DateTimeFromString::create('2020-12-05T02:50:16.123+03:00');
    }


    public function testThrowExceptionWhenCannotCreateDateTimeWithMilliseconds(): void
    {
        $this->expectException(InvalidDateTimeStringException::class);
        $this->expectExceptionMessage(
            sprintf(
                "Can't convert '2020-12-05T02:50:16+03:00' to datetime using format %s.",
                Rfc3339ExtendedFormat::getInputFormat()
            )
        );

        DateTimeFromString::createWithMilliseconds('2020-12-05T02:50:16+03:00');
    }


    /**
     * @dataProvider dateTimeWithTimeZoneAndFormatToCreateProvider
     */
    public function testCreateDateTimeWithTimezoneFromFormat(
        string $expectedDateTime,
        string $format,
        string $dateTimeString,
        DateTimeZone $timeZone
    ): void {
        $dateTime = DateTimeFromString::createWithTimezoneFromFormat($format, $dateTimeString, $timeZone);

        Assert::assertSame($expectedDateTime, $dateTime->format(DateTime::ATOM));
    }


    /**
     * @return mixed[]
     */
    public function dateTimeWithTimeZoneAndFormatToCreateProvider(): array
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

        DateTimeFromString::createFromFormat($format, $dateTimeString);
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

        DateTimeFromString::createWithTimezoneFromFormat($format, $dateTimeString, new DateTimeZone('Europe/Prague'));
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
