<?php declare(strict_types=1);

namespace Audiens\AdForm;

use Audiens\AdForm\Cache\CacheInterface;
use Audiens\AdForm\Manager\AgencyManager;
use Audiens\AdForm\Manager\AudienceManager;
use Audiens\AdForm\Manager\CategoryManager;
use Audiens\AdForm\Manager\DataProviderAudienceManager;
use Audiens\AdForm\Manager\DataUsageManager;
use Audiens\AdForm\Manager\SegmentManager;

class Client
{
    /**
     * Version number of the Adform PHP SDK.
     *
     * @const string
     */
    public const VERSION = '1.0.1';

    /** @var string  */
    public const BASE_URL = 'https://dmp-api.adform.com';

    /** @var Authentication */
    protected $auth;

    /** @var HttpClient */
    protected $httpClient;

    /** @var CacheInterface|null */
    protected $cache;

    /** @var CategoryManager */
    protected static $categories;

    /** @var AudienceManager */
    protected static $audiences;

    /** @var SegmentManager */
    protected static $segments;

    /** @var  AgencyManager */
    protected static $agencies;

    /**  @var DataUsageManager */
    protected $dataUsage;

    /** @var DataProviderAudienceManager */
    protected $dataProviderAudience;


    public function __construct($username, $password, CacheInterface $cache = null)
    {
        $this->auth       = new Authentication($username, $password);
        $this->httpClient = new HttpClient($this->auth);
        $this->cache      = $cache;
    }

    /**
     * A proxy method for working with categories
     * @return CategoryManager
     */
    public function categories(): CategoryManager
    {
        if (static::$categories === null) {
            static::$categories = new CategoryManager($this->httpClient, $this->cache);
        }

        return static::$categories;
    }

    /**
     * A proxy method for working with categories
     */
    public function audience(): AudienceManager
    {
        if (static::$audiences === null) {
            static::$audiences = new AudienceManager($this->httpClient, $this->cache);
        }

        return static::$audiences;
    }

    /**
     * A proxy method for working with segments
     */
    public function segments(): SegmentManager
    {
        if (static::$segments === null) {
            static::$segments = new SegmentManager($this->httpClient, $this->cache);
        }

        return static::$segments;
    }

    /**
     * A proxy method for working with agencies
     */
    public function agencies(): AgencyManager
    {
        if (static::$agencies === null) {
            static::$agencies = new AgencyManager($this->httpClient, $this->cache);
        }

        return static::$agencies;
    }

    /**
     * A proxy method for working with data usage reports
     */
    public function dataUsage(): DataUsageManager
    {
        if ($this->dataUsage === null) {
            $this->dataUsage = new DataUsageManager($this->httpClient, $this->cache);
        }

        return $this->dataUsage;
    }

    /**
     * A proxy method for working with data provider audience reports
     */
    public function dataProviderAudience(): DataProviderAudienceManager
    {
        if ($this->dataProviderAudience === null) {
            $this->dataProviderAudience = new DataProviderAudienceManager($this->httpClient, $this->cache);
        }

        return $this->dataProviderAudience;
    }
}
