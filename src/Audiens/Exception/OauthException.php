<?php

namespace Audiens\AdForm\Exception;

/**
 * Exception thrown if Oauth authentication fails
 */
class OauthException extends SeverityAwareException
{
    const MESSAGE = 'AdForm Authentication failed with message: %s';

    public static function connect($message)
    {
        return new self (
            sprintf(self::MESSAGE, $message),
            0,
            null,
            SeverityAwareException::SEVERITY_CRITICAL
        );
    }
}
