<?php

namespace Audiens\AdForm;

use Audiens\AdForm\Entity\Category;
use Audiens\AdForm\Entity\CategoryHydrator;
use GuzzleHttp\Exception\ClientException;

/**
 * Class RevenueProvider
 *
 * @package Adform
 */
class RevenueProvider
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
     * Constructor.
     *
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient, Cache\CacheInterface $cache = null)
    {
        $this->httpClient = $httpClient;

        $this->cache = $cache;
    }

    /**
     * Returns an array of categories
     *
     * @param int $limit
     * @param int $offset
     *
     * @throws ApiException if the API call fails
     *
     * @return array
     */
    public function getItems($from, $to, $limit = 1000, $offset = 0)
    {
        // Endpoint URI
        $uri = 'v1/reports/datausage';

        $options = [
            'query' => [
                'from' => $from->format('c'),
                'to' => $to->format('c'),
                'limit' => $limit,
                'offset' => $offset,
            ],
        ];

        $revenue = [];

        try {
            $data = null;

            // try to get from cache
            if ($this->cache) {
                $data = $this->cache->get($uri, $options);
            }

            // load from API
            if (!$data) {
                $data = $this->httpClient->get($uri, $options)->getBody()->getContents();

                if ($this->cache and $data) {
                    $this->cache->put($uri, [], $data);
                }
            }

            $classArray = json_decode($data);

            foreach ($classArray as $class) {
                var_dump($class);die();
                $categories[] = $class;
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw new Exception\ApiException($responseBody, $responseCode);
        }

        return $categories;
    }
}
