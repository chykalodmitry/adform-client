<?php

namespace Audiens\AdForm\Exception;

/**
 * Exception thrown if an entity load returns an error
 */
class EntityNotFoundException extends SeverityAwareException
{
    const MESSAGE = 'Entity ID %d not found with message: %s';

    public static function translate($entityId, $message, $code)
    {
        return new self (
            sprintf(self::MESSAGE, $entityId, $message),
            $code,
            null,
            SeverityAwareException::SEVERITY_ERROR
        );
    }
}
