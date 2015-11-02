<?php

namespace Audiens\AdForm\Exception;

/**
 * Exception thrown if an entity storage operation fails
 */
class EntityInvalidException extends SeverityAwareException
{
    const MESSAGE = 'Entity failed validation: %s';

    /**
     * @var mixed
     */
    protected $errors;

    /**
     * @param string     $message
     * @param int        $code
     * @param array      $errors
     * @param \Exception $previous
     * @param int        $severityLevel
     *
     * @internal param object $response The response body
     */
    public function __construct($message = '', $code = 0, $errors = [], \Exception $previous = null, $severityLevel = self::SEVERITY_INFO)
    {
        parent::__construct($message, $code, $previous, $severityLevel);

        $this->errors = (array)$errors;
    }

    /**
     * @param  string $message error message
     * @param  int    $code
     * @param  array  $errors  validation errors
     *
     * @return EntityInvalidException
     */
    public static function invalid($message, $code, $errors)
    {
        return new self (
            sprintf(self::MESSAGE, $message),
            $code,
            $errors,
            null,
            SeverityAwareException::SEVERITY_CRITICAL
        );
    }

    /**
     * Returns the validation errors from the API.
     *
     * @return object
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
