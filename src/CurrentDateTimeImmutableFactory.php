<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTimeImmutable;

final class CurrentDateTimeImmutableFactory implements DateTimeImmutableFactory
{
    public function getNow(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
