<?php declare(strict_types=1);

namespace Audiens\AdForm\Entity;

use DateTime;
use stdClass;

/**
 * Class DataProviderAudienceHydrator
 */
class DataProviderAudienceHydrator extends DataProviderAudience
{
    /**
     * Hydrate a DataProviderAudience from a stdClass, intended to be used for
     * instancing a result from \json_decode()
     *
     * @param stdClass $stdClass
     *
     * @return DataProviderAudience
     */
    public static function fromStdClass(stdClass $stdClass): DataProviderAudience
    {
        $dataProviderAudience = new DataProviderAudience();
        $dataProviderAudience->dataProvider = $stdClass->dataProvider;
        $dataProviderAudience->dataProviderId = $stdClass->dataProviderId;
        $dataProviderAudience->total = (int)$stdClass->total;
        $dataProviderAudience->unique = (int)$stdClass->unique;
        $dataProviderAudience->totalHits = (int)$stdClass->totalHits;
        $dataProviderAudience->uniqueHits = (int)$stdClass->uniqueHits;
        $dataProviderAudience->date = DateParser::parse($stdClass->date);

        return $dataProviderAudience;
    }
}
