<?php declare(strict_types=1);

namespace Audiens\AdForm\Manager;

use Audiens\AdForm\Cache\CacheInterface;
use Audiens\AdForm\Entity\AudienceHydrator;
use Audiens\AdForm\Exception\EntityNotFoundException;
use Audiens\AdForm\HttpClient;
use GuzzleHttp\Exception\ClientException;
use RuntimeException;

class AudienceManager
{
    /** @var HttpClient */
    protected $httpClient;

    /** @var CacheInterface|null */
    protected $cache;

    /** @var string */
    protected $cachePrefix = 'audience';

    public function __construct(HttpClient $httpClient, CacheInterface $cache = null)
    {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
    }

    /**
     * Return an array of Audience based on segment ID
     **/
    public function getItem($segmentId): ?array
    {
        // Endpoint URI
        $uri = sprintf('v2/dmp/segments/%s/audience/totals', $segmentId);

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

            $dataDecoded = \json_decode($data);

            $audiences = [];

            if (\is_array($dataDecoded) && \count($dataDecoded) > 0) {
                foreach ($dataDecoded as $item) {
                    $audiences[] = AudienceHydrator::fromStdClass($item);
                }
            }

            return $audiences;

        } catch (ClientException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                throw new RuntimeException('Null response');
            }
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw EntityNotFoundException::translate($segmentId, $responseBody, $responseCode);
        }

    }
}
