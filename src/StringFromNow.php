<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTimeZone;

final class StringFromNow
{

    /**
     * @var DateTimeImmutableFactory
     */
    private $dateTimeImmutableFactory;

    /**
     * @var DateTimeFormatter
     */
    private $dateTimeFormatter;

    public function __construct(
        DateTimeFormatter $dateTimeFormatter,
        DateTimeImmutableFactory $dateTimeImmutableFactory
    ) {
        $this->dateTimeImmutableFactory = $dateTimeImmutableFactory;
        $this->dateTimeFormatter = $dateTimeFormatter;
    }

    public function formatNowInTimezone(DateTimeZone $dateTimeZone, string $format): string
    {
        $now = $this->dateTimeImmutableFactory->getNow();

        return $this->dateTimeFormatter->formatInTimezone($now, $dateTimeZone, $format);
    }

}
