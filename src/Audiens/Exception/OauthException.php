<?php declare(strict_types=1);

namespace Audiens\AdForm\Exception;

/**
 * Exception thrown if Oauth authentication fails
 */
class OauthException extends SeverityAwareException
{
    protected const MESSAGE = 'AdForm Authentication failed with message: %s';

    public static function connect($message): self
    {
        return new self (
            sprintf(self::MESSAGE, $message),
            0,
            null,
            SeverityAwareException::SEVERITY_CRITICAL
        );
    }
}
