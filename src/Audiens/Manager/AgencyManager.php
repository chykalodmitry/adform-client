<?php declare(strict_types=1);

namespace Audiens\AdForm\Manager;

use Audiens\AdForm\Cache\CacheInterface;
use Audiens\AdForm\Entity\Agency;
use Audiens\AdForm\Entity\AgencyHydrator;
use Audiens\AdForm\Exception\ApiException;
use Audiens\AdForm\Exception\EntityNotFoundException;
use Audiens\AdForm\HttpClient;
use GuzzleHttp\Exception\ClientException;
use RuntimeException;

class AgencyManager
{
    /** @var HttpClient */
    protected $httpClient;

    /** @var CacheInterface|null */
    protected $cache;

    /** @var string */
    protected $cachePrefix = 'agency';

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
     * @throws EntityNotFoundException if the API call fails
     * @throws RuntimeException if the response is null
     *
     * @return Agency
     */
    public function getItem(int $agencyId): Agency
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

                if ($this->cache && $data) {
                    $this->cache->put($this->cachePrefix, $uri, [], $data);
                }
            }

            return AgencyHydrator::fromStdClass(json_decode($data));
        } catch (ClientException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                throw new RuntimeException('Null response');
            }
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw EntityNotFoundException::translate($agencyId, $responseBody, $responseCode);
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
     * @throws ApiException if the API call fails
     * @throws RuntimeException if the response is null
     *
     * @return Agency[]
     */
    public function getItems(int $limit = 1000, int $offset = 0, ?bool $active = null, ?int $countryId = null): array
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

                if ($this->cache && $data) {
                    $this->cache->put($this->cachePrefix, $uri, $options, $data);
                }
            }

            $classArray = \json_decode($data);

            foreach ($classArray as $class) {
                $agencies[] = AgencyHydrator::fromStdClass($class);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                throw new RuntimeException('Null response');
            }
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw ApiException::translate($responseBody, $responseCode);
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
     * @throws ApiException if the API call fails
     * @throws RuntimeException if the response is null
     *
     * @return Agency[]
     */
    public function getItemsDataProvider(int $dataProviderId, int $limit = 1000, int $offset = 0, ?bool $active = null, ?int $countryId = null): array
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

                if ($this->cache && $data) {
                    $this->cache->put($this->cachePrefix, $uri, $options, $data);
                }
            }

            $classArray = \json_decode($data);

            foreach ($classArray as $class) {
                $agencies[] = AgencyHydrator::fromStdClass($class);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                throw new RuntimeException('Null response');
            }
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw ApiException::translate($responseBody, $responseCode);
        }

        return $agencies;
    }

}
