<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTime;
use PHPUnit\Framework\TestCase;

class DateTimeFromTimestampTest extends TestCase
{

    /**
     * @dataProvider timestampProvider
     * @param string $expectedDateTime
     * @param int $timestamp
     */
    public function testShouldCreateDateTimeFromTimestamp(string $expectedDateTime, int $timestamp): void
    {
        $dateTime = DateTimeFromTimestamp::create($timestamp);

        $this->assertSame($expectedDateTime, $dateTime->format(DateTime::ATOM));
    }

    public function timestampProvider(): array
    {
        return [
            ['2017-05-31T13:32:40+00:00', 1496237560],
            ['1970-01-01T00:00:00+00:00', 0],
        ];
    }

}
