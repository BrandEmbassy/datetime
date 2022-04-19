<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime\AmountOfTime;

use Nette\StaticClass;
use Nette\Utils\DateTime;

/**
 * @final
 */
class TimeInSeconds
{
    use StaticClass;

    public const MINUTE = DateTime::MINUTE;
    public const HOUR = DateTime::HOUR;
    public const DAY = DateTime::DAY;
    public const WEEK = DateTime::WEEK;
}
