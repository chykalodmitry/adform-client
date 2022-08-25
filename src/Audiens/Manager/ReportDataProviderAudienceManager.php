<?php declare(strict_types=1);

namespace Audiens\AdForm\Manager;

use Audiens\AdForm\Cache\CacheInterface;
use Audiens\AdForm\Entity\DataProviderAudience;
use Audiens\AdForm\Entity\DataProviderAudienceHydrator;
use Audiens\AdForm\Exception\ApiException;
use Audiens\AdForm\HttpClient;
use DateTime;
use GuzzleHttp\Exception\ClientException;

class ReportDataProviderAudienceManager
{
    /** @var HttpClient */
    protected $httpClient;

    /** @var CacheInterface|null */
    protected $cache;

    /** @var string */
    protected $cachePrefix = 'data_provider_audience';

    public function __construct(HttpClient $httpClient, CacheInterface $cache = null)
    {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
    }

    /**
     * Returns an array of audience objects
     *
     * @param int      $dataProviderId
     * @param DateTime $from
     * @param DateTime $to
     * @param array    $groupBy
     *
     * @return DataProviderAudience[]
     * @throws ApiException if the API call fails
     */
    public function get(int $dataProviderId, DateTime $from, DateTime $to, array $groupBy): array
    {
        // Endpoint URI
        $uri = sprintf('v1/dmp/dataproviders/%d/audience', $dataProviderId);

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

                if ($this->cache && $data) {
                    $this->cache->put($this->cachePrefix, $uri, $options, $data);
                }
            }

            $classArray = \json_decode($data);

            foreach ($classArray as $class) {
                $dataProviderAudiences[] = DataProviderAudienceHydrator::fromStdClass($class);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                throw $e;
            }

            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw new ApiException($responseBody, $responseCode);
        }

        return $dataProviderAudiences;
    }
}
