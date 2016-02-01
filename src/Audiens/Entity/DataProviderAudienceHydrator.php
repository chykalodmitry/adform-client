<?php

namespace Audiens\AdForm\Entity;

/**
 * Class DataProviderAudienceHydrator
 */
class DataProviderAudienceHydrator extends DataProviderAudience
{
    /**
     * Hydrate a DataProviderAudience from a stdClass, intended to be used for
     * instancing a result from json_decode()
     *
     * @param \stdClass $stdClass
     *
     * @return DataProviderAudience
     */
    public static function fromStdClass(\stdClass $stdClass)
    {
        $dataProviderAudience = new DataProviderAudience();
        $dataProviderAudience->dataProvider = $stdClass->dataProvider;
        $dataProviderAudience->dataProviderId = $stdClass->dataProviderId;
        $dataProviderAudience->total = (int)$stdClass->total;
        $dataProviderAudience->unique = (int)$stdClass->unique;
        $dataProviderAudience->totalHits = (int)$stdClass->totalHits;
        $dataProviderAudience->uniqueHits = (int)$stdClass->uniqueHits;
        $dataProviderAudience->date = new \DateTime($stdClass->date);

        return $dataProviderAudience;
    }
}
