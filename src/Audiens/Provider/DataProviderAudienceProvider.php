<?php

namespace Audiens\AdForm\Provider;

use Audiens\AdForm\Entity\DataProviderAudience;
use Audiens\AdForm\Entity\DataProviderAudienceHydrator;
use Audiens\AdForm\HttpClient;
use Audiens\AdForm\Exception;
use Audiens\AdForm\Cache\CacheInterface;
use GuzzleHttp\Exception\ClientException;

/**
 * Class DPAudienceProvider
 *
 * @package Adform
 */
class DataProviderAudienceProvider
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
    protected $cachePrefix = 'data_provider_audience';

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
     * Returns an array of audience objects
     *
     * @param int $dataProviderId
     * @param |DateTime $from
     * @param |DateTime $to
     * @param array $groupBy
     *
     * @throws Exception\ApiException if the API call fails
     *
     * @return DataProviderAudience[]
     */
    public function get($dataProviderId, $from, $to, $groupBy)
    {
        // Endpoint URI
        $uri = 'v1/dataproviders/'.$dataProviderId.'/audience';

        $options = [
            'query' => [
                'from' => $from->format('c'),
                'to' => $to->format('c'),
                'groupBy' => $groupBy,
            ],
        ];

        $dataProviderAudiences = [];

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
                $dataProviderAudiences[] = DataProviderAudienceHydrator::fromStdClass($class);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw new Exception\ApiException($responseBody, $responseCode);
        }

        return $dataProviderAudiences;
    }
}
