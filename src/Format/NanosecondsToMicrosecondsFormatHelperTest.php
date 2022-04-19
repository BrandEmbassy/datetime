<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime\Format;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @final
 */
class NanosecondsToMicrosecondsFormatHelperTest extends TestCase
{
    /**
     * @dataProvider dateTimeAsStringProvider
     */
    public function testTrimNanosecondsIfNeeded(string $expectedString, string $inputString): void
    {
        $trimmedInput = NanosecondsToMicrosecondsFormatHelper::normalizeInputIfNeeded($inputString);

        Assert::assertSame($expectedString, $trimmedInput);
    }


    /**
     * @return string[][]
     */
    public function dateTimeAsStringProvider(): array
    {
        return [
            'Valid with Zero timezone' => [
                'expectedString' => '2021-10-26T15:11:10.114496Z',
                'inputString' => '2021-10-26T15:11:10.114496987Z',
            ],
            'Valid with numeric positive timezone' => [
                'expectedString' => '2017-05-10T12:13:14.222333+05:00',
                'inputString' => '2017-05-10T12:13:14.222333444+05:00',
            ],
            'Valid with numeric negative timezone' => [
                'expectedString' => '2017-05-10T12:13:14.222333-12:00',
                'inputString' => '2017-05-10T12:13:14.222333444-12:00',
            ],
            'Without nanoseconds - no trimming' => [
                'expectedString' => 'no-nanoseconds-present',
                'inputString' => 'no-nanoseconds-present',
            ],
        ];
    }
}
