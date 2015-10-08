<?php

namespace DMP;

/**
 * Class DataProvider
 */
class DataProvider
{

    /** @var int Data provider Id. */
    protected $id;

    /** @var string */
    protected $name;

    /** @var int Data platform Id (for integration). */
    protected $dataPlatformId;

    /** @var string Currency Code. */
    protected $currencyCode;

    /** @var string Data provider description. */
    protected $description;

    /** @var Pricing[] Data provider description. */
    protected $pricing;

    /** @var  DataProviderType[] Data provider type. */
    protected $type;

    /** @var  DataProviderStatus[] Data provider type. */
    protected $status;

    /** @var  int Data provider segments count. */
    protected $segmentsCount;



}
