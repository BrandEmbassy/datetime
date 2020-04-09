<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTime;
use DateTimeZone;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use function sprintf;

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
            ['2017-05-31T13:32:40+00:00', 'U', '1496237560'],
            ['2017-05-10T12:13:14+02:00', DateTime::ATOM, '2017-05-10T12:13:14+02:00'],
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
            ['2017-05-10T12:13:14+02:00', 'Y-m-d H:i:s', '2017-05-10 12:13:14', new DateTimeZone('Europe/Prague')],
            ['2017-05-10T12:13:14+00:00', 'Y-m-d H:i:s', '2017-05-10 12:13:14', new DateTimeZone('UTC')],
        ];
    }


    /**
     * @dataProvider invalidDataProvider
     */
    public function testThrowExceptionWhenCantCreateDateTime(string $format, string $dateTimeString): void
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
    public function testThrowExceptionWhenCantCreateDateTimeWithTimeZone(
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
