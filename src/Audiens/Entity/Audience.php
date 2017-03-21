<?php

namespace Audiens\AdForm\Entity;

use JsonSerializable;

/**
 * Class Audience
 */
class Audience implements JsonSerializable
{
    /**
     * @var string
     */
    protected $segmentId;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var int
     */
    protected $total;

    /**
     * @return string
     */
    public function getSegmentId()
    {
        return $this->segmentId;
    }

    /**
     * @param string $segmentId
     */
    public function setSegmentId($segmentId)
    {
        $this->segmentId = $segmentId;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }


    function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }

}