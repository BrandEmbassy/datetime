<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use DateTimeImmutable;

final class FrozenDateTimeImmutableFactory implements DateTimeImmutableFactory
{
    /**
     * @var DateTimeImmutable
     */
    private $frozenAt;


    public function __construct(DateTimeImmutable $frozenAt)
    {
        $this->frozenAt = $frozenAt;
    }


    public function moveTimeTo(DateTimeImmutable $frozenAt): void
    {
        $this->frozenAt = $frozenAt;
    }


    public function getNow(): DateTimeImmutable
    {
        return $this->frozenAt;
    }
}
