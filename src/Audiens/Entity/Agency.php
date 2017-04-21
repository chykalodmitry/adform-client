<?php

namespace Audiens\AdForm\Entity;

use JsonSerializable;

/**
 * Class Agency
 */
class Agency implements JsonSerializable
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $countryId;

    /**
     * @var bool
     */
    protected $active;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * @param int $countryId
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    function jsonSerialize()
    {
        $json = new \stdClass();

        // might not be set for a new Agency
        if (!is_null($this->id)) {
            $json->id = $this->id;
        }

        $json->name = $this->name;

        // might not be set at all
        if (!is_null($this->countryId)) {
            $json->countryId = $this->countryId;
        }


        $json->active = $this->active;

        return $json;
    }


}