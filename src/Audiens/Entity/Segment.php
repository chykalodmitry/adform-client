<?php

namespace Audiens\AdForm\Entity;

use Audiens\AdForm\Enum\SegmentStatus;
use JsonSerializable;

/**
 * Class Segment
 */
class Segment implements JsonSerializable
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $dataProviderId;

    /**
     * @var SegmentStatus
     */
    protected $status;

    /**
     * @var int
     */
    protected $categoryId;

    /**
     * @var int
     */
    protected $refId;

    /**
     * @var float
     */
    protected $fee;

    /**
     * @var int
     */
    protected $ttl;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $formula;

    /**
     * @var string
     */
    protected $extractionRule;

    /**
     * @var int
     */
    protected $audience;

    /**
     * @var array
     */
    protected $audienceBySources;

    /**
     * @var array
     */
    protected $audienceByUserIdentityType;

    /**
     * @var bool
     */
    protected $isExtended;

    /**
     * @var int
     */
    protected $extensionThreshold;

    /**
     * @var int
     */
    protected $frequency;

    /**
     * @var bool
     */
    protected $isCrossDevice;

    /**
     * @var bool
     */
    protected $hasDataUsagePermissions;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param int $id
     *
     * @return Segment
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getDataProviderId()
    {
        return $this->dataProviderId;
    }

    /**
     * @param int $dataProviderId
     *
     * @return Segment
     */
    public function setDataProviderId($dataProviderId)
    {
        $this->dataProviderId = $dataProviderId;

        return $this;
    }

    /**
     * @return SegmentStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param SegmentStatus $status
     *
     * @return Segment
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     *
     * @return Segment
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * @return int
     */
    public function getRefId()
    {
        return $this->refId;
    }

    /**
     * @param int $refId
     *
     * @return Segment
     */
    public function setRefId($refId)
    {
        $this->refId = $refId;

        return $this;
    }

    /**
     * @return float
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * @param float $fee
     *
     * @return Segment
     */
    public function setFee($fee)
    {
        $this->fee = $fee;

        return $this;
    }

    /**
     * @return int
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * @param int $ttl
     *
     * @return Segment
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Segment
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormula()
    {
        return $this->formula;
    }

    /**
     * @param string $formula
     *
     * @return Segment
     */
    public function setFormula($formula)
    {
        $this->formula = $formula;

        return $this;
    }

    /**
     * @return string
     */
    public function getExtractionRule()
    {
        return $this->extractionRule;
    }

    /**
     * @param string $extractionRule
     *
     * @return Segment
     */
    public function setExtractionRule($extractionRule)
    {
        $this->extractionRule = $extractionRule;

        return $this;
    }

    /**
     * @return int
     */
    public function getAudience()
    {
        return $this->audience;
    }

    /**
     * @param string $audience
     *
     * @return Segment
     */
    public function setAudience($audience)
    {
        $this->audience = $audience;

        return $this;
    }

    /**
     * @return array
     */
    public function getAudienceBySources()
    {
        return $this->audienceBySources;
    }

    /**
     * @param string $audienceBySources
     *
     * @return Segment
     */
    public function setAudienceBySources($audienceBySources)
    {
        $this->audienceBySources = $audienceBySources;

        return $this;
    }

    /**
     * @return array
     */
    public function getAudienceByUserIdentityType()
    {
        return $this->audienceByUserIdentityType;
    }

    /**
     * @param string $audienceByUserIdentityType
     *
     * @return Segment
     */
    public function setAudienceByUserIdentityType($audienceByUserIdentityType)
    {
        $this->audienceByUserIdentityType = $audienceByUserIdentityType;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsExtended()
    {
        return $this->isExtended;
    }

    /**
     * @param string $isExtended
     *
     * @return Segment
     */
    public function setIsExtended($isExtended)
    {
        $this->isExtended = $isExtended;

        return $this;
    }

    /**
     * @return int
     */
    public function getExtensionThreshold()
    {
        return $this->extensionThreshold;
    }

    /**
     * @param string $extensionThreshold
     *
     * @return Segment
     */
    public function setExtensionThreshold($extensionThreshold)
    {
        $this->extensionThreshold = $extensionThreshold;

        return $this;
    }

    /**
     * @return int
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @param int $frequency
     *
     * @return Segment
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsCrossDevice()
    {
        return $this->isCrossDevice;
    }

    /**
     * @param string $isCrossDevice
     *
     * @return Segment
     */
    public function setIsCrossDevice($isCrossDevice)
    {
        $this->isCrossDevice = $isCrossDevice;

        return $this;
    }

    /**
     * @return bool
     */
    public function getHasDataUsagePermissions()
    {
        return $this->hasDataUsagePermissions;
    }

    /**
     * @param string $hasDataUsagePermissions
     *
     * @return Segment
     */
    public function setHasDataUsagePermissions($hasDataUsagePermissions)
    {
        $this->hasDataUsagePermissions = $hasDataUsagePermissions;

        return $this;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        $json = new \stdClass();

        // might not be set for a new segment
        if (!is_null($this->id)) {
            $json->id = $this->id;
        }

        $json->dataProviderId = (int)$this->dataProviderId;

        if (!is_null($this->status)) {
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
        if (isset($this->formula)) {
            $json->formula = $this->formula;
        }

        // might not be set in JSON
        if (isset($this->extractionRule)) {
            $json->extractionRule = $this->extractionRule;
        }

        $json->audience = (bool)$this->audience;
        $json->audienceBySources = $this->audienceBySources;
        $json->audienceByUserIdentityType = $this->audienceByUserIdentityType;
        $json->isExtended = (bool)$this->isExtended;

        // might not be set in JSON
        if (isset($this->extensionThreshold)) {
            $json->extensionThreshold = (bool)$this->extensionThreshold;
        }

        $json->frequency = (int)$this->frequency;
        $json->isCrossDevice = (bool)$this->isCrossDevice;
        $json->hasDataUsagePermissions = (bool)$this->hasDataUsagePermissions;

        // might not be set for a new segment
        if (!is_null($this->createdAt)) {
            $json->createdAt = $this->createdAt->format('c');
        }

        // might not be set for a new segment
        if (!is_null($this->updatedAt)) {
            $json->updatedAt = $this->updatedAt->format('c');
        }

        return $json;
    }
}
