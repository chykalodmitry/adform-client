<?php

namespace Audiens\AdForm\Provider;

use Audiens\AdForm\HttpClient;
use Audiens\AdForm\Exception;
use Audiens\AdForm\Cache\CacheInterface;
use GuzzleHttp\Exception\ClientException;

/**
 * Class RevenueProvider
 *
 * @package Adform
 */
class DataUsageProvider
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @var string
     */
    protected $cachePrefix = 'datausage';

    /**
     * Constructor.
     *
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient, CacheInterface $cache = null)
    {
        $this->httpClient = $httpClient;

        $this->cache = $cache;
    }

    /**
     * Returns an array of data usage objects
     *
     * @param int $dataProviderId
     * @param |DateTime $from
     * @param |DateTime $to
     * @param array $groupBy
     * @param int $limit
     * @param int $offset
     *
     * @throws Exception\ApiException if the API call fails
     *
     * @return array
     */
    public function get($dataProviderId, $from, $to, $groupBy, $limit = 1000, $offset = 0)
    {
        // Endpoint URI
        $uri = 'v1/reports/datausage';

        $options = [
            'query' => [
                'dataProviderId' => $dataProviderId,
                'from' => $from->format('c'),
                'to' => $to->format('c'),
                'groupBy' => $groupBy,
                'limit' => $limit,
                'offset' => $offset,
            ],
        ];

        $usage = [];

        try {
            $data = null;

            // try to get from cache
            if ($this->cache) {
                $data = $this->cache->get($this->cachePrefix, $uri, $options);
            }

            // load from API
            if (!$data) {
                $data = $this->httpClient->get($uri, $options)->getBody()->getContents();

                if ($this->cache and $data) {
                    $this->cache->put($this->cachePrefix, $uri, $options, $data);
                }
            }

            $usage = json_decode($data);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw new Exception\ApiException($responseBody, $responseCode);
        }

        return $usage;
    }
}
