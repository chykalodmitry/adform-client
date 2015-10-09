<?php

namespace DMP;

/**
 * Class DataProvider
 */
class DataProvider
{

    /**
     * @var int Data provider Id.
     * @json_mapping { name: id, type: int }
     */
    protected $id;

    /** @var string */
    protected $name;

    /** @var int Data platform Id (for integration). */
    protected $dataPlatformId;

    /** @var string Currency Code. */
    protected $currencyCode;

    /** @var string Data provider description. */
    protected $description;

    /** @var Pricing Data provider description. */
    protected $pricing;

    /** @var  DataProviderType Data provider type. */
    protected $type;

    /** @var  DataProviderStatus Data provider type. */
    protected $status;

    /** @var int Data provider segments count. */
    protected $segmentsCount;

    /** @var int Max count of segment for this data provider. */
    protected $maxSegmentCount;

    /** @var float Minimal price which possible to set per segment. */
    protected $minimalPrice;

    /** @var float Revenue share. */
    protected $revenueShare;

    /** @var string Pixel URL. */
    protected $pixelUrl;

    /** @var  bool Dynamic segment creation enabled. */
    protected $pixelProfileEnabled;

    /** @var \object List of countries, where the dataprovider is active. */
    protected $activeCountryIds;

    /** @var  \object List of inventory sources for which data is available. */
    protected $inventorySourceIds;

    /** @var  \object List of features which are enabled for this data provider. */
    protected $features;

    /** @var  \object Monthly fee charged from data provider. */
    protected $monthlyFee;

    /** @var  \Datetime */
    protected $updatedAt;

    /** @var  \Datetime */
    protected $createdAt;

    /**
     * DataProvider constructor.
     *
     * @param int                $id
     * @param string             $name
     * @param int                $dataPlatformId
     * @param string             $currencyCode
     * @param string             $description
     * @param Pricing            $pricing
     * @param DataProviderType   $type
     * @param DataProviderStatus $status
     * @param int                $segmentsCount
     * @param int                $maxSegmentCount
     * @param float              $minimalPrice
     * @param float              $revenueShare
     * @param string             $pixelUrl
     * @param bool               $pixelProfileEnabled
     * @param object             $activeCountryIds
     * @param object             $inventorySourceIds
     * @param object             $features
     * @param object             $monthlyFee
     * @param \Datetime          $updatedAt
     * @param \Datetime          $createdAt
     */
    public function __construct(
        $id,
        $name,
        $dataPlatformId,
        $currencyCode,
        $description,
        Pricing $pricing,
        DataProviderType $type,
        DataProviderStatus $status,
        $segmentsCount,
        $maxSegmentCount,
        $minimalPrice,
        $revenueShare,
        $pixelUrl,
        $pixelProfileEnabled,
        $activeCountryIds,
        $inventorySourceIds,
        $features,
        $monthlyFee,
        \Datetime $updatedAt,
        \Datetime $createdAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->dataPlatformId = $dataPlatformId;
        $this->currencyCode = $currencyCode;
        $this->description = $description;
        $this->pricing = $pricing;
        $this->type = $type;
        $this->status = $status;
        $this->segmentsCount = $segmentsCount;
        $this->maxSegmentCount = $maxSegmentCount;
        $this->minimalPrice = $minimalPrice;
        $this->revenueShare = $revenueShare;
        $this->pixelUrl = $pixelUrl;
        $this->pixelProfileEnabled = $pixelProfileEnabled;
        $this->activeCountryIds = $activeCountryIds;
        $this->inventorySourceIds = $inventorySourceIds;
        $this->features = $features;
        $this->monthlyFee = $monthlyFee;
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
    }

    /**
     * @param \stdClass $stdClass
     *
     * @return DataProvider
     */
    public static function fromStdClass(\stdClass $stdClass)
    {

        return new self(
            $stdClass->id,
            $stdClass->name,
            null,
            $stdClass->currencyCode,
            $stdClass->description,
            new Pricing($stdClass->pricing),
            new DataProviderType($stdClass->type),
            new DataProviderStatus($stdClass->status),
            $stdClass->segmentsCount,
            $stdClass->maxSegmentCount,
            $stdClass->minimalPrice,
            $stdClass->revenueShare,
            $stdClass->pixelUrl,
            $stdClass->pixelProfileEnabled,
            $stdClass->activeCountryIds,
            $stdClass->inventorySourceIds,
            $stdClass->features,
            $stdClass->monthlyFee,
            new \DateTime($stdClass->updatedAt),
            new \DateTime($stdClass->createdAt)
        );

    }

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
