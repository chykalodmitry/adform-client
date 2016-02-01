<?php

namespace Audiens\AdForm\Entity;

/**
 * Class Category
 */
class DataProviderAudience
{
    /**
     * @var string
     */
    protected $dataProvider;

    /**
     * @var int
     */
    protected $dataProviderId;

    /**
     * @var int
     */
    protected $total;

    /**
     * @var int
     */
    protected $unique;

    /**
     * @var int
     */
    protected $totalHits;

    /**
     * @var int
     */
    protected $uniqueHits;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @return string
     */
    public function getDataProvider()
    {
        return $this->dataProvider;
    }

    /**
     * @return int
     */
    public function getDataProviderId()
    {
        return $this->dataProviderId;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getUnique()
    {
        return $this->unique;
    }

    /**
     * @return int
     */
    public function getTotalHits()
    {
        return $this->totalHits;
    }

    /**
     * @return int
     */
    public function getUniqueHits()
    {
        return $this->uniqueHits;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
