<?php declare(strict_types=1);

namespace Audiens\AdForm\Exception;

use Throwable;

/**
 * Base Exception
 */
class SeverityAwareException extends \Exception
{
    public const SEVERITY_CRITICAL = 3;
    public const SEVERITY_ERROR = 2;
    public const SEVERITY_NOTICE = 1;
    public const SEVERITY_INFO = 0;

    /**
     * @var int
     */
    private $severityLevel;

    public function __construct(
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null,
        int $severityLevel = self::SEVERITY_INFO
    ) {
        parent::__construct($message, $code, $previous);
        $this->severityLevel = $severityLevel;
    }

    public function getSeverityLevel(): int
    {
        return $this->severityLevel;
    }
}
