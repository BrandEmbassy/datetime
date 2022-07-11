<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use Nette\StaticClass;

/**
 * @final
 */
class DateTimeRegularExpressions
{
    use StaticClass;

    // RFC3339 without milliseconds - non-extended
    // Compliant with \DateTimeInterface::RFC3339
    public const RFC3339 = '#^([0-9]{4})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])T(2[0-3]|[01][0-9]):([0-5][0-9]):([0-5][0-9])(Z|[+-](2[0-3]|[01][0-9]):[0-5][0-9])#';
}
