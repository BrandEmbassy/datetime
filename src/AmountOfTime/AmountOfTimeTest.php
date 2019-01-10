<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime\AmountOfTime;

use PHPUnit\Framework\TestCase;

final class AmountOfTimeTest extends TestCase
{
    /**
     * @dataProvider millisecondsProvider
     */
    public function testShouldConvertTimeFromMilliseconds(
        int $milliseconds,
        int $expectedSeconds,
        int $expectedMinutes
    ): void {
        $amountOfTime = AmountOfTime::fromMilliseconds($milliseconds);

        self::assertSame($milliseconds, $amountOfTime->toMilliseconds());
        self::assertSame($expectedSeconds, $amountOfTime->toSeconds());
        self::assertSame($expectedMinutes, $amountOfTime->toMinutes());
    }


    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingTraversableReturnTypeHintSpecification
     * @return array<string, array<int,int>>
     */
    public function millisecondsProvider(): array
    {
        return [
            'no amount'                             => [0, 0, 0],
            'one millisecond'                       => [1, 0, 0],
            'one second'                            => [1000, 1, 0],
            '5 minutes'                             => [300000, 300, 5],
            '1 hour'                                => [3600000, 3600, 60],
            'not an integer in seconds and minutes' => [6532423, 6532, 108],
        ];
    }


    /**
     * @dataProvider secondsProvider
     */
    public function testShouldConvertTimeFromSeconds(
        int $seconds,
        int $expectedMilliseconds,
        int $expectedMinutes
    ): void {
        $amountOfTime = AmountOfTime::fromSeconds($seconds);

        self::assertSame($expectedMilliseconds, $amountOfTime->toMilliseconds());
        self::assertSame($seconds, $amountOfTime->toSeconds());
        self::assertSame($expectedMinutes, $amountOfTime->toMinutes());
    }


    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingTraversableReturnTypeHintSpecification
     * @return array<string, array<int,int>>
     */
    public function secondsProvider(): array
    {
        return [
            'no amount'                             => [0, 0, 0],
            'one second'                            => [1, 1000, 0],
            '5 minutes'                             => [300, 300000, 5],
            '1 hour'                                => [3600, 3600000, 60],
            'not an integer in seconds and minutes' => [6532, 6532000, 108],
        ];
    }


    /**
     * @dataProvider minutesProvider
     */
    public function testShouldConvertTimeFromMinutes(
        int $minutes,
        int $expectedSeconds,
        int $expectedMilliseconds
    ): void {
        $amountOfTime = AmountOfTime::fromMinutes($minutes);

        self::assertSame($expectedMilliseconds, $amountOfTime->toMilliseconds());
        self::assertSame($expectedSeconds, $amountOfTime->toSeconds());
        self::assertSame($minutes, $amountOfTime->toMinutes());
    }


    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingTraversableReturnTypeHintSpecification
     * @return array<string, array<int,int>>
     */
    public function minutesProvider(): array
    {
        return [
            'no amount'                             => [0, 0, 0],
            '5 minutes'                             => [5, 300, 300000],
            '1 hour'                                => [60, 3600, 3600000],
            'not an integer in seconds and minutes' => [108, 6480, 6480000],
        ];
    }
}
