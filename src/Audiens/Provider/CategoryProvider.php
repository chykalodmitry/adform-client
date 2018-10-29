<?php

namespace Audiens\AdForm\Provider;

use Audiens\AdForm\Cache\CacheInterface;
use Audiens\AdForm\Entity\Category;
use Audiens\AdForm\Entity\CategoryHydrator;
use Audiens\AdForm\Exception\ApiException;
use Audiens\AdForm\Exception\EntityInvalidException;
use Audiens\AdForm\Exception\EntityNotFoundException;
use Audiens\AdForm\HttpClient;
use GuzzleHttp\Exception\ClientException;

/**
 * Class Adform
 *
 * @package Adform
 */
class CategoryProvider
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
    protected $cachePrefix = 'category';

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
     * Return a category based on ID
     *
     * @param int $categoryId ID of the category
     *
     * @throws EntityNotFoundException if the API call fails
     *
     * @return Category
     */
    public function getItem($categoryId)
    {
        // Endpoint URI
        $uri = sprintf('v1/categories/%d', $categoryId);

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

            return CategoryHydrator::fromStdClass(json_decode($data));
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw EntityNotFoundException::translate($categoryId, $responseBody, $responseCode);
        }
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
    public function getItems($limit = 1000, $offset = 0)
    {
        // Endpoint URI
        $uri = 'v1/categories';

        $options = [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
            ],
        ];

        $categories = [];

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
                $categories[] = CategoryHydrator::fromStdClass($class);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw ApiException::translate($responseBody, $responseCode);
        }

        return $categories;
    }

    /**
     * Returns an array of categories for a Data Provider
     *
     * @param int $dataProviderId
     * @param int $limit
     * @param int $offset
     *
     * @throws ApiException if the API call fails
     *
     * @return array
     */
    public function getItemsDataProvider($dataProviderId, $limit = 1000, $offset = 0)
    {
        // Endpoint URI
        $uri = sprintf('v1/dataproviders/%d/categories', $dataProviderId);

        $options = [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
            ],
        ];

        $categories = [];

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
                $categories[] = CategoryHydrator::fromStdClass($class);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw ApiException::translate($responseBody, $responseCode);
        }

        return $categories;
    }

    /**
     * Returns an array of categories for a Data Consumer
     *
     * @param int $dataConsumerId
     * @param int $limit
     * @param int $offset
     *
     * @throws ApiException if the API call fails
     *
     * @return array
     */
    public function getItemsDataConsumer($dataConsumerId, $limit = 1000, $offset = 0)
    {
        // Endpoint URI
        $uri = sprintf('v1/dataconsumers/%d/categories', $dataConsumerId);

        $options = [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
            ],
        ];

        $categories = [];

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
                $categories[] = CategoryHydrator::fromStdClass($class);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw ApiException::translate($responseBody, $responseCode);
        }

        return $categories;
    }

    /**
     * Create a category
     *
     * @param Category $category
     *
     * @throws EntityInvalidException if the API returns a validation error
     * @throws ApiException if the API call fails
     *
     * @return Category
     */
    public function create(Category $category)
    {
        // Endpoint URI
        $uri = 'v1/categories';

        $options = [
            'json' => $category,
        ];

        try {
            $data = $this->httpClient->post($uri, $options)->getBody()->getContents();

            $category = CategoryHydrator::fromStdClass(json_decode($data));

            if ($this->cache and $data) {
                $this->cache->invalidate($this->cachePrefix);
                $this->cache->put($this->cachePrefix, $uri.'/'.$category->getId(), [], $data);
            }

            return $category;

        } catch (ClientException $e) {
            $this->manageClientException($e);
        }

    }

    /**
     * Update a category
     *
     * @param Category $category
     *
     * @throws EntityInvalidException if the API returns a validation error
     * @throws ApiException if the API call fails
     *
     * @return Category
     */
    public function update(Category $category)
    {
        // Endpoint URI
        $uri = sprintf('v1/categories/%d', $category->getId());

        $options = [
            'json' => $category,
        ];

        try {
            $data = $this->httpClient->put($uri, $options)->getBody()->getContents();

            $category = CategoryHydrator::fromStdClass(json_decode($data));

            if ($this->cache and $data) {
                $this->cache->invalidate($this->cachePrefix);
                $this->cache->put($this->cachePrefix, $uri.'/'.$category->getId(), [], $data);
            }

            return $category;
        } catch (ClientException $e) {
            $this->manageClientException($e);
        }
    }

    /**
     * Delete a category
     *
     * @param Category $category
     *
     * @throws ApiException if the API call fails
     *
     * @return bool
     */
    public function delete(Category $category)
    {
        // Endpoint URI
        $uri = sprintf('v1/categories/%d', $category->getId());

        try {
            $this->httpClient->delete($uri);

            if ($this->cache) {
                $this->cache->invalidate($this->cachePrefix);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
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
    protected function manageClientException(ClientException $exception)
    {
        $response = $exception->getResponse();

        if ($response === null) {
            throw $exception;
        }

        $responseBody = $response->getBody()->getContents();
        $responseCode = $response->getStatusCode();

        $error = json_decode($responseBody);

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
                    $errorMessages[] = isset($paramObj->message) ? $paramObj->message : $paramName;
                }
            }

            throw EntityInvalidException::invalid(
                $responseBody,
                $responseCode,
                \implode("\n", $errorMessages)
            );
        }

        // Generic exception
        throw ApiException::translate($responseBody, $responseCode);
    }
}
