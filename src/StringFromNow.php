<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTimeZone;

final class StringFromNow
{
    private DateTimeImmutableFactory $dateTimeImmutableFactory;


    public function __construct(DateTimeImmutableFactory $dateTimeImmutableFactory)
    {
        $this->dateTimeImmutableFactory = $dateTimeImmutableFactory;
    }


    public function formatNowInTimezone(DateTimeZone $dateTimeZone, string $format): string
    {
        $now = $this->dateTimeImmutableFactory->getNow();

        return DateTimeFormatter::formatInTimezoneAs($now, $dateTimeZone, $format);
    }
}
