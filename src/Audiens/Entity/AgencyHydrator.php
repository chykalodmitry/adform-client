<?php declare(strict_types=1);

namespace Audiens\AdForm\Entity;

use stdClass;

class AgencyHydrator extends Agency
{
    /**
     * Hydrate an agency from a stdClass, intended to be used for
     * instancing a category from \json_decode()
     *
     * @param stdClass $stdClass
     *
     * @return Agency
     */
    public static function fromStdClass(stdClass $stdClass): Agency
    {
        $agency = new Agency();

        $agency->id = $stdClass->id;
        $agency->name = $stdClass->name;
        $agency->countryId = $stdClass->countryId;
        $agency->active = $stdClass->active;

        return $agency;
    }
}
