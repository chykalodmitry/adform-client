<?php declare(strict_types=1);

namespace Audiens\AdForm\Entity;

use DateTime;

/**
 * Class Category
 */
class DataProviderAudience
{
    /** @var string|null */
    protected $dataProvider;

    /** @var int|null */
    protected $dataProviderId;

    /** @var int|null */
    protected $total;

    /** @var int|null */
    protected $unique;

    /** @var int|null */
    protected $totalHits;

    /** @var int|null */
    protected $uniqueHits;

    /** @var DateTime|null */
    protected $date;

    public function getDataProvider(): ?string
    {
        return $this->dataProvider;
    }

    public function getDataProviderId(): ?int
    {
        return $this->dataProviderId;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function getUnique(): ?int
    {
        return $this->unique;
    }

    public function getTotalHits(): ?int
    {
        return $this->totalHits;
    }

    public function getUniqueHits(): ?int
    {
        return $this->uniqueHits;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }
}
