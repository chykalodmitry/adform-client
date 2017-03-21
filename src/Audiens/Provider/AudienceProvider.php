<?php

namespace Audiens\AdForm\Provider;

use Audiens\AdForm\Cache\CacheInterface;
use Audiens\AdForm\Entity\Audience;
use Audiens\AdForm\Entity\AudienceHydrator;
use Audiens\AdForm\Exception\EntityNotFoundException;
use Audiens\AdForm\HttpClient;
use GuzzleHttp\Exception\ClientException;


/**
 * Class Adform
 *
 * @package Adform
 */
class AudienceProvider
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
    protected $cachePrefix = 'audience';

    /**
     * Constructor.
     *
     * @param HttpClient $httpClient
     * @param CacheInterface|null $cache
     */
    public function __construct(HttpClient $httpClient, CacheInterface $cache = null)
    {
        $this->httpClient = $httpClient;

        $this->cache = $cache;
    }

    /**
     * Return an array of Audience based on segment ID
     *
     * @param $segmentId
     * @return array|Audience[]
     * @throws EntityNotFoundException
     */
    public function getItem($segmentId)
    {
        // Endpoint URI
        $uri = sprintf('v2/segments/%s/audience/totals', $segmentId);

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

            $dataDecoded = json_decode($data);

            $audiences = [];

            if (is_array($dataDecoded) && count($dataDecoded) > 0) {
                foreach ($dataDecoded as $item) {
                    $audiences[] = AudienceHydrator::fromStdClass($item);
                }
            }

            return $audiences;

        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw EntityNotFoundException::translate($segmentId, $responseBody, $responseCode);
        }

    }
}