<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTimeImmutable;

interface DateTimeImmutableFactory
{
    public function getNow(): DateTimeImmutable;
}
