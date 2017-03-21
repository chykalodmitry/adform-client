<?php

namespace Audiens\AdForm\Entity;

/**
 * Class AudienceHydrator
 */
class AudienceHydrator extends Audience
{
    /**
     * Hydrate a category from a stdClass, intended to be used for
     * instancing a category from json_decode()
     *
     * @param \stdClass $stdClass
     *
     * @return Audience
     */
    public static function fromStdClass(\stdClass $stdClass)
    {
        $audience = new Audience();

        $audience->segmentId = $stdClass->segmentId;
        $audience->date = $stdClass->date;
        $audience->total = $stdClass->total;

        return $audience;
    }

}