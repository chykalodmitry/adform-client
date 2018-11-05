<?php declare(strict_types=1);

namespace Audiens\AdForm\Entity;

use DateTime;
use stdClass;

/**
 * Class AudienceHydrator
 */
class AudienceHydrator extends Audience
{
    /**
     * Hydrate a category from a stdClass, intended to be used for
     * instancing an audience from \json_decode()
     *
     * @param stdClass $stdClass
     *
     * @return Audience
     */
    public static function fromStdClass(stdClass $stdClass): Audience
    {
        $audience = new Audience();

        $audience->segmentId = $stdClass->segmentId;
        $audience->date = DateParser::parse($stdClass->date);
        $audience->total = $stdClass->total;

        return $audience;
    }

}
