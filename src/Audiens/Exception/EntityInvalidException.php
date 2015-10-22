<?php

namespace Audiens\AdForm\Exception;

/**
 * Exception thrown if an entity storage operation fails
 */
class EntityInvalidException extends \Exception
{
    /**
     * @var mixed
     */
    protected $errors;

    /**
     * @param string $message
     * @param int $code
     * @param object $response The response body
     */
    public function __construct($message, $code, $errors)
    {
        $this->errors = (array)$errors;
        parent::__construct($message, $code);
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
