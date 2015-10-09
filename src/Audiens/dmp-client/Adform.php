<?php

namespace DMP;

use GuzzleHttp\Client;

/**
 * Class Adform
 *
 * @package Adform
 */
class Adform
{
    /**
     * @const string Version number of the Adform PHP SDK.
     */
    const VERSION = '0.0.0';

    const BASE_URI = 'https://dmp-api.adform.com';

    /** @var */
    protected $oauthClient;

    /** @var  Autentication */
    protected $autentication;

    /** @var Client */
    protected $client;

    /** @var */
    protected $baseUri;

    /** @var */
    protected $username;

    /** @var */
    protected $password;

    /**
     * @param OauthClient $client
     */
    public function __construct(OauthClient $client)
    {
        $this->client = $client;

    }

    /**
     * @param $currencyCodes array Collection of string
     * @param $search        string
     * @param $filter        string
     * @param $sort
     * @param $offset        int
     * @param $limit         int
     *
     * @return DataProvider[]
     *
     * Returns list of available providers Use "ActiveCountryIds eq global" for filtering of globally
     * active DataProviders, or "ActiveCountryIds eq [10, 17, 53] for filtering of DataProviders,
     * active just in specified countries"
     *
     */
    public function getDataProviders($offset = 0, $limit = 100)
    {

        $respose = $this->client->get(
            'v1/dataproviders',
            [
                'query' =>
                    [
                        'limit' => $limit,
                        'offset' => $offset,
                    ],
            ]
        );

        $dataProviders = [];

        $classArray = json_decode($respose->getBody()->getContents());

        foreach ($classArray as $class) {
            $dataProviders [] = DataProvider::fromStdClass($class);
        }

        return $dataProviders;

    }


    /**
     *
     */
    public function getSegments($dataProviderId, $offset = 0, $limit = 1000)
    {

        $url = sprintf('v1/dataproviders/{%s}/segments', $dataProviderId);

        $respose = $this->client->get(
            $url,
            [
                'query' =>
                    [
                        'limit' => $limit,
                        'offset' => $offset,
                    ],
            ]
        );

        $segments = [];

        $classArray = json_decode($respose->getBody()->getContents());

        foreach ($classArray as $class) {
            $dataProviders [] = DataProvider::fromStdClass($class);
        }

        return $dataProviders;


    }


}
