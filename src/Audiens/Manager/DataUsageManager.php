<?php declare(strict_types=1);

namespace Audiens\AdForm\Manager;

use Audiens\AdForm\Cache\CacheInterface;
use Audiens\AdForm\Exception\ApiException;
use Audiens\AdForm\HttpClient;
use DateTime;
use GuzzleHttp\Exception\ClientException;

class DataUsageManager
{
    /** @var HttpClient */
    protected $httpClient;

    /** @var CacheInterface */
    protected $cache;

    /** @var string */
    protected $cachePrefix = 'datausage';

    public function __construct(HttpClient $httpClient, CacheInterface $cache = null)
    {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
    }

    /**
     * Returns an array of data usage objects
     *
     * @param int $dataProviderId
     * @param DateTime $from
     * @param DateTime $to
     * @param array $groupBy
     * @param int $limit
     * @param int $offset
     *
     * @throws ApiException if the API call fails
     *
     * @return array
     */
    public function get(int $dataProviderId, DateTime $from, DateTime $to, array $groupBy, int $limit = 1000, int $offset = 0): array
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

            return \json_decode($data);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                throw $e;
            }
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw new ApiException($responseBody, $responseCode);
        }

    }
}
