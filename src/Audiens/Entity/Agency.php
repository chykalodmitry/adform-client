<?php declare(strict_types=1);

namespace Audiens\AdForm\Entity;

use JsonSerializable;
use stdClass;

/**
 * Class Agency
 */
class Agency implements JsonSerializable
{
    /** @var string|null */
    protected $id;

    /** @var string|null */
    protected $name;

    /** @var int|null */
    protected $countryId;

    /** @var bool */
    protected $active;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCountryId(): ?int
    {
        return $this->countryId;
    }

    public function setCountryId(int $countryId): void
    {
        $this->countryId = $countryId;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function jsonSerialize()
    {
        $json = new stdClass();

        // might not be set for a new Agency
        if ($this->id !== null) {
            $json->id = $this->id;
        }

        $json->name = $this->name;

        // might not be set at all
        if ($this->countryId !== null) {
            $json->countryId = $this->countryId;
        }

        $json->active = $this->active;

        return $json;
    }


}
