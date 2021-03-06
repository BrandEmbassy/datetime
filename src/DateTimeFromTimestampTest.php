<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class DateTimeFromTimestampTest extends TestCase
{
    /**
     * @dataProvider timestampProvider
     */
    public function testCreateDateTimeFromTimestamp(string $expectedDateTime, int $timestamp): void
    {
        $dateTime = DateTimeFromTimestamp::create($timestamp);

        Assert::assertSame($expectedDateTime, $dateTime->format(DateTime::ATOM));
    }


    /**
     * @return mixed[]
     */
    public function timestampProvider(): array
    {
        return [
            ['2017-05-31T13:32:40+00:00', 1496237560],
            ['1970-01-01T00:00:00+00:00', 0],
        ];
    }


    /**
     * @dataProvider timestampWithMillisecondsProvider
     */
    public function testCreateDateTimeFromTimestampInMilliseconds(string $expectedDateTime, int $timestamp): void
    {
        $dateTime = DateTimeFromTimestamp::createIncludingMilliseconds($timestamp);

        Assert::assertSame($expectedDateTime, $dateTime->format(DateTime::ATOM));
    }


    /**
     * @return mixed[]
     */
    public function timestampWithMillisecondsProvider(): array
    {
        return [
            ['2017-05-31T13:32:40+00:00', 1496237560000],
            ['2017-05-31T13:32:40+00:00', 1496237560123],
            ['1970-01-01T00:00:00+00:00', 0],
        ];
    }
}
