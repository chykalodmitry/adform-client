<?php

namespace DATA\segment;

/**
 * Class Segment
 */
class Segment
{

  protected $id;
  protected $dataProviderId;
  protected $status;
  protected $categoryId;
  protected $refId;
  protected $fee;
  protected $ttl;
  protected $name;
  protected $formula;
  protected $extractionRule;
  protected $audience;
  protected $extended;
  protected $original;
  protected $isExtended;
  protected $extensionThreshold;
  protected $frequency;
  protected $isCrossDevice;

    /**
     * @param \stdClass $stdClass
     *
     * @return mixed|\stdClass
     * @throws \Exception
     */
    protected static function validateStdClass(\stdClass $stdClass)
    {

        $failures = [];

        $expectedProperties = [
            'id',
            'name',
            'currencyCode',
            'description',
            'pricing',
            'type',
            'status',
            'segmentsCount',
            'maxSegmentCount',
            'minimalPrice',
            'revenueShare',
            'pixelUrl',
            'pixelProfileEnabled',
            'activeCountyIds',
            'monthlyFee',
            'updatedAt',
        ];

        foreach ($expectedProperties as $property) {
            if (!$stdClass->$property) {
                $failures[] = $property;
            }
        }

        $failureMessagge = implode(', ', $failures);

        if ($failureMessagge != '') {
            throw new \Exception('missing: '.$failureMessagge);
        }

        return $stdClass;

    }


}
