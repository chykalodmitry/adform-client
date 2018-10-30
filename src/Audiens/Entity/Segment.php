<?php declare(strict_types=1);

namespace Audiens\AdForm\Entity;

use Audiens\AdForm\Enum\SegmentStatus;
use DateTime;
use JsonSerializable;

/**
 * Class Segment
 */
class Segment implements JsonSerializable
{
    /** @var int|null */
    protected $id;

    /** @var int|null */
    protected $dataProviderId;

    /** @var SegmentStatus|null */
    protected $status;

    /** @var int|null */
    protected $categoryId;

    /** @var string|null */
    protected $refId;

    /** @var float|null */
    protected $fee;

    /** @var int|null */
    protected $ttl;

    /** @var string|null */
    protected $name;

    /** @var string|null */
    protected $formula;

    /** @var string|null */
    protected $extractionRule;

    /** @var int|null */
    protected $audience;

    /** @var array|null */
    protected $audienceBySources;

    /** @var array|null */
    protected $audienceByUserIdentityType;

    /** @var bool|null */
    protected $isExtended;

    /** @var int|null */
    protected $extensionThreshold;

    /** @var int|null */
    protected $frequency;

    /** @var bool|null */
    protected $isCrossDevice;

    /** @var bool|null */
    protected $hasDataUsagePermissions;

    /** @var DateTime|null */
    protected $updatedAt;

    /** @var DateTime|null */
    protected $createdAt;

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getDataProviderId(): ?int
    {
        return $this->dataProviderId;
    }

    public function setDataProviderId(int $dataProviderId): self
    {
        $this->dataProviderId = $dataProviderId;

        return $this;
    }

    public function getStatus(): ?SegmentStatus
    {
        return $this->status;
    }

    public function setStatus(SegmentStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    public function getRefId(): ?string
    {
        return $this->refId;
    }

    public function setRefId(string $refId): self
    {
        $this->refId = $refId;

        return $this;
    }

    public function getFee(): ?float
    {
        return $this->fee;
    }

    public function setFee(float $fee): self
    {
        $this->fee = $fee;

        return $this;
    }

    public function getTtl(): ?int
    {
        return $this->ttl;
    }

    public function setTtl(int $ttl): self
    {
        $this->ttl = $ttl;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFormula(): ?string
    {
        return $this->formula;
    }

    public function setFormula(string $formula): self
    {
        $this->formula = $formula;

        return $this;
    }

    public function getExtractionRule(): ?string
    {
        return $this->extractionRule;
    }

    public function setExtractionRule(string $extractionRule): self
    {
        $this->extractionRule = $extractionRule;

        return $this;
    }

    public function getAudience(): ?int
    {
        return $this->audience;
    }

    public function setAudience(string $audience): self
    {
        $this->audience = $audience;

        return $this;
    }

    public function getAudienceBySources(): ?array
    {
        return $this->audienceBySources;
    }

    public function setAudienceBySources(string $audienceBySources): self
    {
        $this->audienceBySources = $audienceBySources;

        return $this;
    }

    public function getAudienceByUserIdentityType(): ?array
    {
        return $this->audienceByUserIdentityType;
    }

    public function setAudienceByUserIdentityType(string $audienceByUserIdentityType): self
    {
        $this->audienceByUserIdentityType = $audienceByUserIdentityType;

        return $this;
    }

    public function getIsExtended(): ?bool
    {
        return $this->isExtended;
    }

    public function setIsExtended(bool $isExtended): self
    {
        $this->isExtended = $isExtended;

        return $this;
    }

    public function getExtensionThreshold(): ?int
    {
        return $this->extensionThreshold;
    }

    public function setExtensionThreshold(int $extensionThreshold): self
    {
        $this->extensionThreshold = $extensionThreshold;

        return $this;
    }

    public function getFrequency(): ?int
    {
        return $this->frequency;
    }

    public function setFrequency(int $frequency): self
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getIsCrossDevice(): ?bool
    {
        return $this->isCrossDevice;
    }

    public function setIsCrossDevice(bool $isCrossDevice): self
    {
        $this->isCrossDevice = $isCrossDevice;

        return $this;
    }

    public function getHasDataUsagePermissions(): ?bool
    {
        return $this->hasDataUsagePermissions;
    }

    public function setHasDataUsagePermissions(bool $hasDataUsagePermissions): self
    {
        $this->hasDataUsagePermissions = $hasDataUsagePermissions;

        return $this;
    }

    public function jsonSerialize()
    {
        $json = new \stdClass();

        // might not be set for a new segment
        if ($this->id !== null) {
            $json->id = $this->id;
        }

        $json->dataProviderId = (int)$this->dataProviderId;

        if ($this->status !== null) {
            $json->status = $this->status->getValue();
        } else {
            $json->status = null;
        }

        $json->categoryId = (int)$this->categoryId;
        $json->refId = $this->refId;
        $json->fee = (float)$this->fee;
        $json->ttl = (int)$this->ttl;
        $json->name = $this->name;

        // might not be set in JSON
        if ($this->formula !== null) {
            $json->formula = $this->formula;
        }

        // might not be set in JSON
        if ($this->extractionRule !== null) {
            $json->extractionRule = $this->extractionRule;
        }

        $json->audience = (bool)$this->audience;
        $json->audienceBySources = $this->audienceBySources;
        $json->audienceByUserIdentityType = $this->audienceByUserIdentityType;
        $json->isExtended = (bool)$this->isExtended;

        // might not be set in JSON
        if ($this->extensionThreshold !== null) {
            $json->extensionThreshold = (bool)$this->extensionThreshold;
        }

        $json->frequency = (int)$this->frequency;
        $json->isCrossDevice = (bool)$this->isCrossDevice;
        $json->hasDataUsagePermissions = (bool)$this->hasDataUsagePermissions;

        // might not be set for a new segment
        if ($this->createdAt !== null) {
            $json->createdAt = $this->createdAt->format('c');
        }

        // might not be set for a new segment
        if ($this->updatedAt !== null) {
            $json->updatedAt = $this->updatedAt->format('c');
        }

        return $json;
    }
}
