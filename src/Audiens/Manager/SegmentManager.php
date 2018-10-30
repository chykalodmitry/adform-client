<?php declare(strict_types=1);

namespace Audiens\AdForm\Manager;

use Audiens\AdForm\Cache\CacheInterface;
use Audiens\AdForm\Entity\Segment;
use Audiens\AdForm\Entity\SegmentHydrator;
use Audiens\AdForm\Exception\ApiException;
use Audiens\AdForm\Exception\EntityInvalidException;
use Audiens\AdForm\Exception\EntityNotFoundException;
use Audiens\AdForm\HttpClient;
use GuzzleHttp\Exception\ClientException;

class SegmentManager
{
    /** @var HttpClient */
    protected $httpClient;

    /** @var CacheInterface */
    protected $cache;

    /** @var string */
    protected $cachePrefix = 'segment';

    public function __construct(HttpClient $httpClient, ?CacheInterface $cache = null)
    {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
    }

    /**
     * Return a category based on ID
     *
     * @param int $segmentId ID of the category
     *
     * @throws EntityNotFoundException if the API call fails
     *
     * @return Segment
     */
    public function getItem($segmentId): Segment
    {
        // Endpoint URI
        $uri = sprintf('v1/segments/%d', $segmentId);

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

            return SegmentHydrator::fromStdClass(json_decode($data));
        } catch (ClientException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                throw $e;
            }
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw EntityNotFoundException::translate($segmentId, $responseBody, $responseCode);
        }
    }

    /**
     * Returns an array of segments
     *
     * @param int $limit
     * @param int $offset
     *
     * @throws ApiException if the API call fails
     *
     * @return Segment[]
     */
    public function getItems(int $limit = 1000, int $offset = 0): array
    {
        // Endpoint URI
        $uri = 'v1/segments';

        $options = [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
            ],
        ];

        return $this->getSegmentsFromListEndpoint($uri, $options);
    }

    /**
     * Returns an array of segments for a Data Provider
     *
     * @param int $dataProviderId
     * @param int $limit
     * @param int $offset

     * @throws ApiException if the API call fails
     *
     * @return Segment[]
     */
    public function getItemsDataProvider(int $dataProviderId, int $limit = 1000, int $offset = 0): array
    {
        // Endpoint URI
        $uri = sprintf('v1/dataproviders/%d/segments', $dataProviderId);

        $options = [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
            ],
        ];

        return $this->getSegmentsFromListEndpoint($uri, $options);
    }

    /**
     * Returns an array of segments for a Category
     *
     * @param int $categoryId
     * @param int $limit
     * @param int $offset
     *
     * @throws ApiException if the API call fails
     *
     * @return Segment[]
     */
    public function getItemsCategory(int $categoryId, int $limit = 1000, int $offset = 0): array
    {
        // Endpoint URI
        $uri = sprintf('v1/categories/%d/segments', $categoryId);

        $options = [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
            ],
        ];

        return $this->getSegmentsFromListEndpoint($uri, $options);
    }

    /**
     * Returns an array of segments for a Data Consumer
     *
     * @param int $dataConsumerId
     * @param int $limit
     * @param int $offset
     *
     * @throws ApiException if the API call fails
     *
     * @return Segment[]
     */
    public function getItemsDataConsumer(int $dataConsumerId, int $limit = 1000, int $offset = 0): array
    {
        // Endpoint URI
        $uri = sprintf('v1/dataconsumers/%d/segments', $dataConsumerId);

        $options = [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
            ],
        ];

        return $this->getSegmentsFromListEndpoint($uri, $options);
    }

    /**
     * @param string $uri
     * @param array  $options
     *
     * @return array
     * @throws ApiException
     */
    private function getSegmentsFromListEndpoint(string $uri, array $options)
    {
        $segments = [];

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
                $segments[] = SegmentHydrator::fromStdClass($class);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                throw $e;
            }
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw ApiException::translate($responseBody, $responseCode);
        }

        return $segments;
    }

    /**
     * Create a category
     *
     * @param Segment $segment
     *
     * @throws EntityInvalidException if the API returns a validation error
     * @throws ApiException if the API call fails
     *
     * @return Segment
     */
    public function create(Segment $segment): Segment
    {
        // Endpoint URI
        $uri = 'v1/segments';

        $options = [
            'json' => $segment,
        ];

        try {
            $data = $this->httpClient->post($uri, $options)->getBody()->getContents();

            $segment = SegmentHydrator::fromStdClass(json_decode($data));

            if ($this->cache && $data) {
                $this->cache->invalidate($this->cachePrefix);
                $this->cache->put($this->cachePrefix, $uri.'/'.$segment->getId(), [], $data);
            }
        } catch (ClientException $e) {
            $this->manageClientException($e);
        }

        return $segment;
    }

    /**
     * Update a category
     *
     * @param Segment $segment
     *
     * @throws EntityInvalidException if the API returns a validation error
     * @throws ApiException if the API call fails
     *
     * @return Segment
     */
    public function update(Segment $segment): Segment
    {
        // Endpoint URI
        $uri = sprintf('v1/segments/%d', $segment->getId());

        $options = [
            'json' => $segment,
        ];

        try {
            $data = $this->httpClient->put($uri, $options)->getBody()->getContents();

            $segment = SegmentHydrator::fromStdClass(json_decode($data));

            if ($this->cache && $data) {
                $this->cache->invalidate($this->cachePrefix);
                $this->cache->put($this->cachePrefix, $uri.'/'.$segment->getId(), [], $data);
            }
        } catch (ClientException $e) {
            $this->manageClientException($e);
        }

        return $segment;
    }

    /**
     * Delete a category
     *
     * @param Segment $segment
     *
     * @throws ApiException if the API call fails
     *
     * @return bool
     */
    public function delete(Segment $segment): bool
    {
        // Endpoint URI
        $uri = sprintf('v1/segments/%d', $segment->getId());

        try {

            $this->httpClient->delete($uri);

            if ($this->cache) {
                $this->cache->invalidate($this->cachePrefix);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                throw $e;
            }
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw ApiException::translate($responseBody, $responseCode);
        }

        return true;
    }

    /**
     * @param ClientException $exception
     *
     * @throws EntityInvalidException
     * @throws ApiException
     */
    protected function manageClientException(ClientException $exception): void
    {
        $response = $exception->getResponse();

        if ($response === null) {
            throw $exception;
        }

        $responseBody = $response->getBody()->getContents();
        $responseCode = $response->getStatusCode();

        $error = \json_decode($responseBody);

        // Validation
        if (isset($error->modelState)) {
            throw EntityInvalidException::invalid($responseBody, $responseCode, $error->modelState);
        }

        if (isset($error->reason, $error->params) && $error->reason === 'validationFailed') {
            $errorMessages = [];
            foreach ($error->params as $paramName => $paramArr) {
                if (!\is_array($paramArr)) {
                    $errorMessages[] = $paramName;

                    continue;
                }

                foreach ($paramArr as $paramObj) {
                    $errorMessages[] = $paramObj->message ?? $paramName;
                }
            }

            throw EntityInvalidException::invalid(
                $responseBody,
                $responseCode,
                $errorMessages
            );
        }

        // Generic exception
        throw ApiException::translate($responseBody, $responseCode);
    }
}
