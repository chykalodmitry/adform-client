<?php

namespace Audiens\AdForm\Provider;

use Audiens\AdForm\Entity\Agency;
use Audiens\AdForm\Entity\AgencyHydrator;
use Audiens\AdForm\HttpClient;
use Audiens\AdForm\Exception;
use Audiens\AdForm\Cache\CacheInterface;
use GuzzleHttp\Exception\ClientException;

/**
 * Class AgencyProvider
 *
 * @package Adform
 */
class AgencyProvider
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
    protected $cachePrefix = 'agency';

    /**
     * @param HttpClient $httpClient
     * @param CacheInterface|null $cache
     */
    public function __construct(HttpClient $httpClient, CacheInterface $cache = null)
    {
        $this->httpClient = $httpClient;

        $this->cache = $cache;
    }

    /**
     * Return an agency based on ID
     *
     * @param int $agencyId ID of the agency
     *
     * @throws Exception\EntityNotFoundException if the API call fails
     *
     * @return Agency
     */
    public function getItem($agencyId)
    {
        // Endpoint URI
        $uri = sprintf('v1/agencies/%d', $agencyId);

        try {
            $data = null;

            // try to get from cache
            if ($this->cache) {
                $data = $this->cache->get($this->cachePrefix, $uri, []);
            }

            // load from API
            if (!$data) {
                $data = $this->httpClient->get($uri)->getBody()->getContents();

                if ($this->cache and $data) {
                    $this->cache->put($this->cachePrefix, $uri, [], $data);
                }
            }

            return AgencyHydrator::fromStdClass(json_decode($data));
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw Exception\EntityNotFoundException::translate($agencyId, $responseBody, $responseCode);
        }
    }

    /**
     * Returns an array of agencies
     *
     * @param int $limit
     * @param int $offset
     * @param bool $active
     * @param int $countryId
     *
     * @throws Exception\ApiException if the API call fails
     *
     * @return array
     */
    public function getItems($limit = 1000, $offset = 0, $active = null, $countryId = null)
    {
        // Endpoint URI
        $uri = 'v1/agencies';

        $options = [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
                'active' => $active,
                'countryId' => $countryId
            ],
        ];


        $agencies = [];

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

            $classArray = json_decode($data);

            foreach ($classArray as $class) {
                $agencies[] = AgencyHydrator::fromStdClass($class);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw Exception\ApiException::translate($responseBody, $responseCode);
        }

        return $agencies;
    }

    /**
     * Returns an array of agencies for a Data Provider
     *
     * @param int $dataProviderId
     * @param int $limit
     * @param int $offset
     * @param bool $active
     * @param int $countryId
     *
     * @throws Exception\ApiException if the API call fails
     *
     * @return array
     */
    public function getItemsDataProvider($dataProviderId, $limit = 1000, $offset = 0, $active = null, $countryId = null)
    {
        // Endpoint URI
        $uri = sprintf('v1/dataproviders/%d/agencies', $dataProviderId);

        $options = [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
                'active' => $active,
                'countryId' => $countryId
            ],
        ];


        $agencies = [];

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

            $classArray = json_decode($data);

            foreach ($classArray as $class) {
                $agencies[] = AgencyHydrator::fromStdClass($class);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw Exception\ApiException::translate($responseBody, $responseCode);
        }

        return $agencies;
    }

}
