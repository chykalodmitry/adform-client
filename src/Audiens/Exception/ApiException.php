<?php declare(strict_types=1);

namespace Audiens\AdForm\Exception;

/**
 * Exception thrown if API returns an error not handled by other exceptions
 */
class ApiException extends SeverityAwareException
{
    protected const MESSAGE = 'API returned an error: %s';

    public static function translate(string $message, int $code): self
    {
        return new self (
            sprintf(self::MESSAGE, $message),
            $code,
            null,
            SeverityAwareException::SEVERITY_ERROR
        );
    }
}
