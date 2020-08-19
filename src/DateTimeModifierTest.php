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
    public function testGetBeginningOfTheDay(int $expectedTimestamp, int $originTimestamp): void
    {
        $originDateTime = DateTimeFromTimestamp::create($originTimestamp);

        Assert::assertSame($expectedTimestamp, DateTimeModifier::getBeginningOfTheDay($originDateTime)->getTimestamp());
    }


    /**
     * @return int[][]
     */
    public function getBeginningOfTheDayDataProvider(): array
    {
        return [
            ['expectedTimestamp' => 1597708800, 'originTimestamp' => 1597709898],
            ['expectedTimestamp' => 1597795200, 'originTimestamp' => 1597834270],
            ['expectedTimestamp' => 1598918400, 'originTimestamp' => 1598957623],
        ];
    }


    /**
     * @dataProvider getBeginningOfTheDayInTimezoneDataProvider
     */
    public function testGetBeginningOfTheDayInTimezone(
        int $expectedTimestamp,
        int $originTimestamp,
        string $dateTimeZoneName
    ): void {
        $originDateTime = DateTimeFromTimestamp::create($originTimestamp);
        $dateTimeZone = new DateTimeZone($dateTimeZoneName);

        Assert::assertSame(
            $expectedTimestamp,
            DateTimeModifier::getBeginningOfTheDayInTimezone($originDateTime, $dateTimeZone)->getTimestamp()
        );
    }


    /**
     * @return mixed[]
     */
    public function getBeginningOfTheDayInTimezoneDataProvider(): array
    {
        return [
            ['expectedTimestamp' => 1597795200, 'originTimestamp' => 1597834270, 'dateTimeZoneName' => 'UTC'],
            ['expectedTimestamp' => 1597788000, 'originTimestamp' => 1597834270, 'dateTimeZoneName' => 'Europe/Prague'],
            ['expectedTimestamp' => 1597791600, 'originTimestamp' => 1597834270, 'dateTimeZoneName' => 'Europe/London'],
        ];
    }


    /**
     * @dataProvider getEndOfTheDayDataProvider
     */
    public function testGetEndOfTheDay(int $expectedTimestamp, int $originTimestamp): void
    {
        $originDateTime = DateTimeFromTimestamp::create($originTimestamp);

        Assert::assertSame($expectedTimestamp, DateTimeModifier::getEndOfTheDay($originDateTime)->getTimestamp());
    }


    /**
     * @return int[][]
     */
    public function getEndOfTheDayDataProvider(): array
    {
        return [
            ['expectedTimestamp' => 1597881599, 'originTimestamp' => 1597835685],
            ['expectedTimestamp' => 1597881599, 'originTimestamp' => 1597834270],
            ['expectedTimestamp' => 1599004799, 'originTimestamp' => 1598957623],
        ];
    }


    /**
     * @dataProvider getEndOfTheDayInTimezoneDataProvider
     */
    public function testGetEndOfTheDayInTimezone(
        int $expectedTimestamp,
        int $originTimestamp,
        string $dateTimeZoneName
    ): void {
        $originDateTime = DateTimeFromTimestamp::create($originTimestamp);
        $dateTimeZone = new DateTimeZone($dateTimeZoneName);

        Assert::assertSame(
            $expectedTimestamp,
            DateTimeModifier::getEndOfTheDayInTimezone($originDateTime, $dateTimeZone)->getTimestamp()
        );
    }


    /**
     * @return mixed[]
     */
    public function getEndOfTheDayInTimezoneDataProvider(): array
    {
        return [
            ['expectedTimestamp' => 1597881599, 'originTimestamp' => 1597834270, 'dateTimeZoneName' => 'UTC'],
            ['expectedTimestamp' => 1597874399, 'originTimestamp' => 1597834270, 'dateTimeZoneName' => 'Europe/Prague'],
            ['expectedTimestamp' => 1597877999, 'originTimestamp' => 1597834270, 'dateTimeZoneName' => 'Europe/London'],
        ];
    }
}
