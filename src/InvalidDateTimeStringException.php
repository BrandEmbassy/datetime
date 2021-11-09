<?php declare(strict_types = 1);

namespace BrandEmbassy\DateTime;

use InvalidArgumentException;
use function array_values;
use function sprintf;

final class InvalidDateTimeStringException extends InvalidArgumentException
{
    /**
     * @var string[]
     */
    private array $errors;

    /**
     * @var string[]
     */
    private array $warnings;


    public static function byNoDatetimeString(
        string $requiredFormat,
        string $dateTimeStringInNotRecognizedFormat
    ): self {
        $message = sprintf(
            "Can't convert '%s' to datetime using format %s.",
            $dateTimeStringInNotRecognizedFormat,
            $requiredFormat
        );

        return new self($message);
    }


    /**
     * @param string[] $errors
     * @param string[] $warnings
     */
    public static function byValidationErrors(string $dateTimeStringWithErrors, array $errors, array $warnings): self
    {
        $message = sprintf("Datetime '%s' cannot be considered as fully valid string.", $dateTimeStringWithErrors);

        return new self($message, $errors, $warnings);
    }


    /**
     * @param string[] $errors
     * @param string[] $warnings
     */
    private function __construct(string $message, array $errors = [], array $warnings = [])
    {
        parent::__construct($message);

        $this->errors = array_values($errors);
        $this->warnings = array_values($warnings);
    }


    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }


    /**
     * @return string[]
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }
}
