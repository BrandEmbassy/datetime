<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTimeZone;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class DateTimeModifierTest extends TestCase
{
    /**
     * @dataProvider getBeginningOfTheDayDataProvider
     */
    public function testGetBeginningOfTheDay(string $expectedAtom, string $originAtom): void
    {
        $originDateTime = DateTimeFromString::createFromAtom($originAtom);
        $expectedDateTime = DateTimeFromString::createFromAtom($expectedAtom);

        Assert::assertSame(
            DateTimeFormatter::formatAsAtom($expectedDateTime),
            DateTimeFormatter::formatAsAtom(DateTimeModifier::getBeginningOfTheDay($originDateTime))
        );
    }


    /**
     * @return string[][]
     */
    public function getBeginningOfTheDayDataProvider(): array
    {
        return [
            ['expectedAtom' => '2020-08-18T00:00:00+02:00', 'originAtom' => '2020-08-18T02:18:18+02:00'],
            ['expectedAtom' => '2020-08-18T00:00:00+02:00', 'originAtom' => '2020-08-18T00:00:00+02:00'],
            ['expectedAtom' => '2020-08-18T00:00:00+02:00', 'originAtom' => '2020-08-18T23:59:59+02:00'],
            ['expectedAtom' => '2020-08-18T00:00:00+01:00', 'originAtom' => '2020-08-18T00:00:01+01:00'],
            ['expectedAtom' => '2020-08-18T00:00:00+01:00', 'originAtom' => '2020-08-18T11:59:00+01:00'],
            ['expectedAtom' => '2020-08-18T00:00:00-04:00', 'originAtom' => '2020-08-18T11:59:00-04:00'],
        ];
    }


    /**
     * @dataProvider getBeginningOfTheDayInTimezoneDataProvider
     */
    public function testGetBeginningOfTheDayInTimezone(
        string $expectedAtom,
        string $originAtom,
        string $dateTimeZoneName
    ): void {
        $originDateTime = DateTimeFromString::createFromAtom($originAtom);
        $expectedDateTime = DateTimeFromString::createFromAtom($expectedAtom);

        $dateTimeZone = new DateTimeZone($dateTimeZoneName);

        Assert::assertSame(
            DateTimeFormatter::formatAsAtom($expectedDateTime),
            DateTimeFormatter::formatAsAtom(
                DateTimeModifier::getBeginningOfTheDayInTimezone($originDateTime, $dateTimeZone)
            )
        );
    }


    /**
     * @return string[][]
     */
    public function getBeginningOfTheDayInTimezoneDataProvider(): array
    {
        return [
            [
                'expectedAtom' => '2020-08-18T00:00:00+00:00',
                'originAtom' => '2020-08-18T02:18:18+02:00',
                'dateTimeZoneName' => 'UTC',
            ],
            [
                'expectedAtom' => '2020-08-18T00:00:00+02:00',
                'originAtom' => '2020-08-18T02:18:18+02:00',
                'dateTimeZoneName' => 'Europe/Prague',
            ],
            [
                'expectedAtom' => '2020-08-18T00:00:00+01:00',
                'originAtom' => '2020-08-18T02:18:18+02:00',
                'dateTimeZoneName' => 'Europe/London',
            ],
            [
                'expectedAtom' => '2020-08-17T00:00:00-06:00',
                'originAtom' => '2020-08-18T02:18:18+02:00',
                'dateTimeZoneName' => 'America/Denver',
            ],
        ];
    }


    /**
     * @dataProvider getEndOfTheDayDataProvider
     */
    public function testGetEndOfTheDay(string $expectedAtom, string $originAtom): void
    {
        $originDateTime = DateTimeFromString::createFromAtom($originAtom);
        $expectedDateTime = DateTimeFromString::createFromAtom($expectedAtom);

        Assert::assertSame(
            DateTimeFormatter::formatAsAtom($expectedDateTime),
            DateTimeFormatter::formatAsAtom(DateTimeModifier::getEndOfTheDay($originDateTime))
        );
    }


    /**
     * @return string[][]
     */
    public function getEndOfTheDayDataProvider(): array
    {
        return [
            ['expectedAtom' => '2020-08-18T23:59:59+02:00', 'originAtom' => '2020-08-18T02:18:18+02:00'],
            ['expectedAtom' => '2020-08-18T23:59:59+02:00', 'originAtom' => '2020-08-18T23:59:59+02:00'],
            ['expectedAtom' => '2020-08-18T23:59:59+01:00', 'originAtom' => '2020-08-18T00:00:01+01:00'],
            ['expectedAtom' => '2020-08-18T23:59:59+01:00', 'originAtom' => '2020-08-18T11:59:00+01:00'],
            ['expectedAtom' => '2020-08-18T23:59:59+01:00', 'originAtom' => '2020-08-18T23:59:59+01:00'],
            ['expectedAtom' => '2020-08-18T23:59:59-04:00', 'originAtom' => '2020-08-18T11:59:00-04:00'],
        ];
    }


    /**
     * @dataProvider getEndOfTheDayInTimezoneDataProvider
     */
    public function testGetEndOfTheDayInTimezone(
        string $expectedAtom,
        string $originAtom,
        string $dateTimeZoneName
    ): void {
        $originDateTime = DateTimeFromString::createFromAtom($originAtom);
        $expectedDateTime = DateTimeFromString::createFromAtom($expectedAtom);

        $dateTimeZone = new DateTimeZone($dateTimeZoneName);

        Assert::assertSame(
            DateTimeFormatter::formatAsAtom($expectedDateTime),
            DateTimeFormatter::formatAsAtom(
                DateTimeModifier::getEndOfTheDayInTimezone($originDateTime, $dateTimeZone)
            )
        );
    }


    /**
     * @return string[][]
     */
    public function getEndOfTheDayInTimezoneDataProvider(): array
    {
        return [
            [
                'expectedAtom' => '2020-08-18T23:59:59+00:00',
                'originAtom' => '2020-08-18T02:18:18+02:00',
                'dateTimeZoneName' => 'UTC',
            ],
            [
                'expectedAtom' => '2020-08-18T23:59:59+02:00',
                'originAtom' => '2020-08-18T02:18:18+02:00',
                'dateTimeZoneName' => 'Europe/Prague',
            ],
            [
                'expectedAtom' => '2020-08-18T23:59:59+01:00',
                'originAtom' => '2020-08-18T02:18:18+02:00',
                'dateTimeZoneName' => 'Europe/London',
            ],
            [
                'expectedAtom' => '2020-08-17T23:59:59-06:00',
                'originAtom' => '2020-08-18T02:18:18+02:00',
                'dateTimeZoneName' => 'America/Denver',
            ],
        ];
    }
}
