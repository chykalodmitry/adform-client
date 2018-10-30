<?php declare(strict_types=1);

namespace Audiens\AdForm\Exception;

use Throwable;

/**
 * Exception thrown if an entity storage operation fails
 */
class EntityInvalidException extends SeverityAwareException
{
    protected const MESSAGE = 'Entity failed validation: %s';

    /**
     * @var mixed
     */
    protected $errors;

    public function __construct(
        string $message = '',
        int $code = 0,
        array $errors = [],
        ?Throwable $previous = null,
        int $severityLevel = self::SEVERITY_INFO
    ) {
        parent::__construct($message, $code, $previous, $severityLevel);

        $this->errors = $errors;
    }

    public static function invalid(string $message, int $code, array $errors): self
    {
        return new self (
            sprintf(self::MESSAGE, $message),
            $code,
            $errors,
            null,
            SeverityAwareException::SEVERITY_CRITICAL
        );
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
