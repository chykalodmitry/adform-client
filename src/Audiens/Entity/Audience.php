<?php declare(strict_types=1);

namespace Audiens\AdForm\Entity;

use DateTime;
use JsonSerializable;
use stdClass;

/**
 * Class Audience
 */
class Audience implements JsonSerializable
{
    /** @var string|null */
    protected $segmentId;

    /** @var DateTime|null */
    protected $date;

    /** @var int|null */
    protected $total;

    public function getSegmentId(): ?string
    {
        return $this->segmentId;
    }

    public function setSegmentId(string $segmentId): void
    {
        $this->segmentId = $segmentId;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    public function jsonSerialize()
    {
        $obj = new stdClass();

        $obj->segmentId = $this->segmentId;
        $obj->date = $this->date ? $this->date->format('c'): null;
        $obj->total = $this->total;

        return $obj;
    }
}
