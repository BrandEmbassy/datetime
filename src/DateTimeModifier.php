<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTimeImmutable;
use DateTimeZone;
use Nette\StaticClass;

final class DateTimeModifier
{
    use StaticClass;


    public static function getBeginningOfTheDay(DateTimeImmutable $originDateTime): DateTimeImmutable
    {
        return $originDateTime->modify('midnight');
    }


    public static function getEndOfTheDay(DateTimeImmutable $originDateTime): DateTimeImmutable
    {
        return $originDateTime->modify('tomorrow')->modify('-1 second');
    }


    public static function getBeginningOfTheDayInTimezone(
        DateTimeImmutable $originDateTime,
        DateTimeZone $dateTimeZone
    ): DateTimeImmutable {
        return self::getBeginningOfTheDay($originDateTime->setTimezone($dateTimeZone));
    }


    public static function getEndOfTheDayInTimezone(
        DateTimeImmutable $originDateTime,
        DateTimeZone $dateTimeZone
    ): DateTimeImmutable {
        return self::getEndOfTheDay($originDateTime->setTimezone($dateTimeZone));
    }
}
