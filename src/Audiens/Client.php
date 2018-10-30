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

    /**
     * URL for the AdForm API.
     *
     * @const string
     */
    public const BASE_URL = 'https://dmp-api.adform.com';

    /** @var Authentication */
    protected $auth;

    /** @var HttpClient */
    protected $httpClient;

    /** @var CacheInterface */
    protected $cache;

    /** @var CategoryManager */
    protected $categories;

    /** @var AudienceManager */
    protected $audiences;

    /** @var SegmentManager */
    protected $segments;

    /** @var  AgencyManager */
    protected $agencies;

    /**
     * @var DataUsageManager
     */
    protected $dataUsage;

    /** @var DataProviderAudienceManager */
    protected $dataProviderAudience;

    /**
     * Constructor.
     *
     * @param string              $username
     * @param string              $password
     * @param CacheInterface|null $cache
     *
     * @throws Exception\OauthException
     */
    public function __construct($username, $password, CacheInterface $cache = null)
    {
        $this->auth = new Authentication($username, $password);
        $this->httpClient = new HttpClient($this->auth);
        $this->cache = $cache;
    }

    /**
     * A proxy method for working with categories
     * @return CategoryManager
     */
    public function categories(): CategoryManager
    {
        if ($this->categories === null) {
            $this->categories = new CategoryManager($this->httpClient, $this->cache);
        }

        return $this->categories;
    }

    /**
     * A proxy method for working with categories
     * @return AudienceManager
     */
    public function audience(): AudienceManager
    {
        if ($this->audiences === null) {
            $this->audiences = new AudienceManager($this->httpClient, $this->cache);
        }
        return $this->audiences;
    }

    /**
     * A proxy method for working with segments
     * @return SegmentManager
     */
    public function segments(): SegmentManager
    {
        if ($this->segments === null) {
            $this->segments = new SegmentManager($this->httpClient, $this->cache);
        }

        return $this->segments;
    }

    /**
     * A proxy method for working with agencies
     * @return AgencyManager
     */
    public function agencies(): AgencyManager
    {
        if ($this->agencies === null) {
            $this->agencies = new AgencyManager($this->httpClient, $this->cache);
        }

        return $this->agencies;
    }

    /**
     * A proxy method for working with data usage reports
     * @return DataUsageManager
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
     * @return DataProviderAudienceManager
     */
    public function dataProviderAudience(): DataProviderAudienceManager
    {
        if ($this->dataProviderAudience === null) {
            $this->dataProviderAudience = new DataProviderAudienceManager($this->httpClient, $this->cache);
        }

        return $this->dataProviderAudience;
    }
}
