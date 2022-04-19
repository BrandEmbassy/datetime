<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime\AmountOfTime;

use InvalidArgumentException;
use function floor;

/**
 * @final
 */
class AmountOfTime
{
    private const SECOND_IN_MILLISECOND = 1000;

    private int $milliseconds;


    /**
     * @throws InvalidArgumentException
     */
    private function __construct(int $milliseconds)
    {
        if ($milliseconds < 0) {
            throw new InvalidArgumentException('Ammount of millisecond can\'t be negative number.');
        }

        $this->milliseconds = $milliseconds;
    }


    public function __toString(): string
    {
        return (string)($this->milliseconds / self::SECOND_IN_MILLISECOND);
    }


    /**
     * @throws InvalidArgumentException
     */
    public static function fromMilliseconds(int $milliseconds): self
    {
        return new self($milliseconds);
    }


    /**
     * @throws InvalidArgumentException
     */
    public static function fromSeconds(int $seconds): self
    {
        return new self($seconds * self::SECOND_IN_MILLISECOND);
    }


    /**
     * @throws InvalidArgumentException
     */
    public static function fromMinutes(int $minutes): self
    {
        return new self($minutes * TimeInSeconds::MINUTE * self::SECOND_IN_MILLISECOND);
    }


    /**
     * @throws InvalidArgumentException
     */
    public static function fromDays(int $days): self
    {
        return new self($days * TimeInSeconds::DAY * self::SECOND_IN_MILLISECOND);
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


    public function toDays(): int
    {
        return (int)floor($this->toSeconds() / TimeInSeconds::DAY);
    }
}
