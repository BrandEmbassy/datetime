<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime\Doctrine;

use BrandEmbassy\DateTime\DateTimeFromTimestamp;
use DateTimeImmutable;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use function is_float;

final class DateTimeImmutableAsTimestampDoctrineType extends Type
{
    public const NAME = 'datetime_immutable_as_timestamp';
    private const EMPTY_DATETIME = '0000-00-00 00:00:00';


    /**
     * @param mixed $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        if ($value === null) {
            return null;
        }

        if (!$value instanceof DateTimeImmutable) {
            throw new InvalidArgumentException('Given value is not instance of DateTimeImmutable.');
        }

        return $value->getTimestamp();
    }


    /**
     * @phpcsSuppress BrandEmbassyCodingStandard.NamingConvention.CamelCapsFunctionName
     *
     * @param mixed $value
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?DateTimeImmutable
    {
        if ($value === '' || $value === null || $value === self::EMPTY_DATETIME) {
            return null;
        }

        if ($value instanceof DateTimeImmutable) {
            return $value;
        }

        if (!$this->isIntValue($value)) {
            throw new InvalidArgumentException('Given value must by convertible to int.');
        }

        return DateTimeFromTimestamp::create((int)$value);
    }


    /**
     * @phpcsSuppress BrandEmbassyCodingStandard.NamingConvention.CamelCapsFunctionName
     *
     * @param mixed[] $fieldDeclaration
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return 'INT(11)';
    }


    public function getName(): string
    {
        return self::NAME;
    }


    /**
     * @param string|int|float $value
     */
    public function isIntValue($value): bool
    {
        return !is_float($value) && (string)(int)$value === (string)$value;
    }
}
