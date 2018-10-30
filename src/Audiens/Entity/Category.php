<?php declare(strict_types=1);

namespace Audiens\AdForm\Entity;

use DateTime;
use JsonSerializable;

/**
 * Class Category
 */
class Category implements JsonSerializable
{
    /** @var int|null */
    protected $id;

    /** @var string|null */
    protected $name;

    /** @var int|null */
    protected $dataProviderId;

    /** @var int|null */
    protected $parentId;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): Category
    {
        $this->name = $name;

        return $this;
    }

    public function getDataProviderId(): ?int
    {
        return $this->dataProviderId;
    }

    public function setDataProviderId(int $dataProviderId): Category
    {
        $this->dataProviderId = $dataProviderId;

        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(int $parentId): Category
    {
        $this->parentId = $parentId;

        return $this;
    }

    public function jsonSerialize()
    {
        $json = new \stdClass();

        // might not be set for a new category
        if ($this->id !== null) {
            $json->id = $this->id;
        }

        $json->name = $this->name;
        $json->dataProviderId = $this->dataProviderId;

        // might not be set at all
        if ($this->parentId !== null) {
            $json->parentId = $this->parentId;
        }

        // might not be set for a new category
        if ($this->createdAt !== null) {
            $json->createdAt = $this->createdAt->format('c');
        }

        // might not be set for a new category
        if ($this->updatedAt !== null) {
            $json->updatedAt = $this->updatedAt->format('c');
        }

        return $json;
    }
}
