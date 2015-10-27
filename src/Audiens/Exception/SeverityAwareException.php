<?php

namespace Audiens\AdForm\Exception;

/**
 * Base Exception
 */
class SeverityAwareException extends \Exception
{
    const SEVERITY_CRITICAL = 3;
    const SEVERITY_ERROR = 2;
    const SEVERITY_NOTICE = 1;
    const SEVERITY_INFO = 0;

    /**
     * @var int
     */
    private $severityLevel;

    /**
     * @param string $message error message
     * @param integer $code error code
     * @param Exception $previous
     * @param int $severityLevel
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null, $severityLevel = self::SEVERITY_INFO)
    {
        parent::__construct($message, $code, $previous);
        $this->severityLevel = $severityLevel;
    }

    /**
     * @return int
     */
    public function getSeverityLevel()
    {
        return $this->severityLevel;
    }
}
