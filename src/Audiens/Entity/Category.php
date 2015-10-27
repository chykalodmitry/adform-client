<?php

namespace Audiens\AdForm\Entity;

use JsonSerializable;

/**
 * Class Category
 */
class Category implements JsonSerializable
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $dataProviderId;

    /**
     * @var int
     */
    protected $parentId;

    /**
     * @var DateTime
     */
    protected $updatedAt;

    /**
     * @var DateTime
     */
    protected $createdAt;

    /**
     * Constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * @return Category
     */
    public function setDataProviderId($dataProviderId)
    {
        $this->dataProviderId = $dataProviderId;

        return $this;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     *
     * @return Category
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        $json = new \stdClass();

        // might not be set for a new category
        if (!is_null($this->id)) {
            $json->id = $this->id;
        }

        $json->name = $this->name;
        $json->dataProviderId = $this->dataProviderId;

        // might not be set at all
        if (!is_null($this->parentId)) {
            $json->parentId = $this->parentId;
        }

        // might not be set for a new category
        if (!is_null($this->createdAt)) {
            $json->createdAt = $this->createdAt->format('c');
        }

        // might not be set for a new category
        if (!is_null($this->updatedAt)) {
            $json->updatedAt = $this->updatedAt->format('c');
        }

        return $json;
    }
}
