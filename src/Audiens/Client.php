<?php

namespace Audiens\AdForm;

/**
 * Class Adform
 *
 * @package Adform
 */
class Client
{
    /**
     * Version number of the Adform PHP SDK.
     *
     * @const string
     */
    const VERSION = '0.1.0';

    /**
     * URL for the AdForm API.
     *
     * @const string
     */
    const BASE_URL = 'https://dmp-api.adform.com';

    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * Constructor.
     *
     * @param string $username
     * @param string $password
     * @param CacheInterface $cache
     */
    public function __construct($username, $password, CacheInterface $cache = null)
    {
        $this->auth = new Authentication($username, $password);

        $this->httpClient = new HttpClient($this->auth);

        // providers for entity types
        $this->categories = new CategoryProvider($this->httpClient);
        //$this->segments = new Segments($this->httpClient);
    }
}
