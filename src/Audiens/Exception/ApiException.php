<?php

namespace Audiens\AdForm\Exception;

/**
 * Exception thrown if API returns an error not handled by other exceptions
 */
class ApiException extends SeverityAwareException
{
    const MESSAGE = 'API returned an error: %s';

    public static function translate($message, $code)
    {
        return new self (
            sprintf(self::MESSAGE, $message),
            $code,
            null,
            SeverityAwareException::SEVERITY_ERROR
        );
    }
}
