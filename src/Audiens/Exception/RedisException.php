<?php

namespace Audiens\AdForm\Exception;

/**
 * Exception thrown if Redis fails
 */
class RedisException extends SeverityAwareException
{
    const MESSAGE = 'Redis connection failed with message: %s';

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
