<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTimeImmutable;
use PHPStan\Testing\TestCase;
use PHPUnit\Framework\Assert;

final class DateTimeFormatterTest extends TestCase
{
    public function testFormatToAtom(): void
    {
        $dateTimeInAtom = '2017-05-10T12:13:14+02:00';
        $formattedDateTime = DateTimeFormatter::formatAsAtom(new DateTimeImmutable($dateTimeInAtom));

        Assert::assertSame($dateTimeInAtom, $formattedDateTime);
    }
}
