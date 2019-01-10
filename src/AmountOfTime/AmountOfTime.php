<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime\AmountOfTime;

use Assert\Assertion;
use function floor;

final class AmountOfTime
{
    private const SECOND_IN_MILLISECOND = 1000;

    /**
     * @var int
     */
    private $milliseconds;


    private function __construct(int $milliseconds)
    {
        Assertion::greaterOrEqualThan($milliseconds, 0);
        $this->milliseconds = $milliseconds;
    }


    public static function fromMilliseconds(int $milliseconds): self
    {
        return new self($milliseconds);
    }


    public static function fromSeconds(int $seconds): self
    {
        return new self($seconds * self::SECOND_IN_MILLISECOND);
    }


    public static function fromMinutes(int $minutes): self
    {
        return new self($minutes * TimeInSeconds::MINUTE * self::SECOND_IN_MILLISECOND);
    }


    public function toMilliseconds(): int
    {
        return $this->milliseconds;
    }


    public function toSeconds(): int
    {
        return (int)floor($this->milliseconds / self::SECOND_IN_MILLISECOND);
    }


    public function toMinutes(): int
    {
        return (int)floor($this->toSeconds() / TimeInSeconds::MINUTE);
    }
}
