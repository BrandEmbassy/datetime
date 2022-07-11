<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use function preg_match;

/**
 * @final
 */
class DateTimeRegularExpressionsTest extends TestCase
{
    /**
     * @dataProvider dateTimeStringsDataProvider
     */
    public function testDateTimeStringMatchesPattern(
        bool $expectedMatch,
        string $pattern,
        string $dateTime
    ): void {
        $doesMatch = (bool)preg_match($pattern, $dateTime);

        Assert::assertSame($expectedMatch, $doesMatch);
    }


    /**
     * @return array<string, array<string, mixed>>
     */
    public function dateTimeStringsDataProvider(): array
    {
        return [
            'RFC3339 | Valid DateTime with specified positive timezone' => [
                'expectedMatch' => true,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-12-31T23:59:59+01:00',
            ],
            'RFC3339 | Valid DateTime with specified negative timezone' => [
                'expectedMatch' => true,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-12-31T23:59:59-01:00',
            ],
            'RFC3339 | Valid DateTime with "Zulu" (UTC offset of 00:00) timezone' => [
                'expectedMatch' => true,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-12-31T23:59:59Z',
            ],
            'RFC3339 | Invalid milliseconds' => [
                'expectedMatch' => false,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-12-31T23:59:59.123Z',
            ],
            'RFC3339 | Invalid year' => [
                'expectedMatch' => false,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '19999-12-31T23:59:59Z',
            ],
            'RFC3339 | Invalid month - 0' => [
                'expectedMatch' => false,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-0-31T23:59:59Z',
            ],
            'RFC3339 | Invalid month - 13' => [
                'expectedMatch' => false,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-13-31T23:59:59Z',
            ],
            'RFC3339 | Invalid day - 0' => [
                'expectedMatch' => false,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-12-0T23:59:59Z',
            ],
            'RFC3339 | Invalid day - 32' => [
                'expectedMatch' => false,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-12-32T23:59:59Z',
            ],
            'RFC3339 | Invalid hour - 0' => [
                'expectedMatch' => false,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-12-31T0:59:59Z',
            ],
            'RFC3339 | Invalid hour - 24' => [
                'expectedMatch' => false,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-12-31T24:59:59Z',
            ],
            'RFC3339 | Invalid minute - 0' => [
                'expectedMatch' => false,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-12-31T23:0:59Z',
            ],
            'RFC3339 | Invalid minute - 60' => [
                'expectedMatch' => false,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-12-31T23:60:59Z',
            ],
            'RFC3339 | Invalid second - 0' => [
                'expectedMatch' => false,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-12-31T23:59:0Z',
            ],
            'RFC3339 | Invalid second - 60' => [
                'expectedMatch' => false,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-12-31T23:59:60Z',
            ],
            'RFC3339 | Invalid timezone hour - 0' => [
                'expectedMatch' => false,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-12-31T23:59:59+0:00',
            ],
            'RFC3339 | Invalid timezone hour - 24' => [
                'expectedMatch' => false,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-12-31T23:59:59+24:00',
            ],
            'RFC3339 | Invalid timezone minute - 0' => [
                'expectedMatch' => false,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-12-31T23:59:59+01:0',
            ],
            'RFC3339 | Invalid timezone minute - 60' => [
                'expectedMatch' => false,
                'pattern' => DateTimeRegularExpressions::RFC3339,
                'dateTime' => '2000-12-31T23:59:59+01:60',
            ],
        ];
    }
}
