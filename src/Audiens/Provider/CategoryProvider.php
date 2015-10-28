<?php

namespace Audiens\AdForm\Provider;

use Audiens\AdForm\Entity\Category;
use Audiens\AdForm\Entity\CategoryHydrator;
use Audiens\AdForm\HttpClient;
use Audiens\AdForm\Exception;
use Audiens\AdForm\Cache\CacheInterface;
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
     * Return a category based on ID
     *
     * @param int $categoryId ID of the category
     *
     * @throws Exception\EntityNotFoundException if the API call fails
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
                $data = $this->cache->get($uri, []);
            }

            // load from API
            if (!$data) {
                $data = $this->httpClient->get($uri)->getBody()->getContents();

                if ($this->cache and $data) {
                    $this->cache->put($uri, [], $data);
                }
            }

            return CategoryHydrator::fromStdClass(json_decode($data));
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw Exception\EntityNotFoundException::translate($categoryId, $responseBody, $responseCode);
        }
    }

    /**
     * Returns an array of categories
     *
     * @param int $limit
     * @param int $offset
     *
     * @throws Exception\ApiException if the API call fails
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
                $data = $this->cache->get($uri, $options);
            }

            // load from API
            if (!$data) {
                $data = $this->httpClient->get($uri, $options)->getBody()->getContents();

                if ($this->cache and $data) {
                    $this->cache->put($uri, $options, $data);
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

            throw Exception\ApiException::translate($responseBody, $responseCode);
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
     * @throws Exception\ApiException if the API call fails
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
                $data = $this->cache->get($uri, $options);
            }

            // load from API
            if (!$data) {
                $data = $this->httpClient->get($uri, $options)->getBody()->getContents();

                if ($this->cache and $data) {
                    $this->cache->put($uri, $options, $data);
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

            throw Exception\ApiException::translate($responseBody, $responseCode);
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
     * @throws Exception\ApiException if the API call fails
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
                $data = $this->cache->get($uri, $options);
            }

            // load from API
            if (!$data) {
                $data = $this->httpClient->get($uri, $options)->getBody()->getContents();

                if ($this->cache and $data) {
                    $this->cache->put($uri, $options, $data);
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

            throw Exception\ApiException::translate($responseBody, $responseCode);
        }

        return $categories;
    }

    /**
     * Create a category
     *
     * @param Category $category
     *
     * @throws Exception\EntityInvalidException if the API returns a validation error
     * @throws Exception\ApiException if the API call fails
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
                $this->cache->put($uri.'/'.$category->getId(), [], $data);
            }

            return $category;

        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            $error = json_decode($responseBody);

            if (property_exists($error, 'modelState')) { // validation error
                throw Exception\EntityInvalidException::invalid($responseBody, $responseCode, $error->modelState);
            } else { // general error
                throw Exception\ApiException::translate($responseBody, $responseCode);
            }
        }

    }

    /**
     * Update a category
     *
     * @param Category $category
     *
     * @throws Exception\EntityInvalidException if the API returns a validation error
     * @throws Exception\ApiException if the API call fails
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
                $this->cache->put($uri.'/'.$category->getId(), [], $data);
            }

            return $category;
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            $error = json_decode($responseBody);

            if (property_exists($error, 'modelState')) { // validation error
                throw Exception\EntityInvalidException::invalid($responseBody, $responseCode, $error->modelState);
            } else { // general error
                throw Exception\ApiException::translate($responseBody, $responseCode);
            }
        }

    }

    /**
     * Delete a category
     *
     * @param Category $category
     *
     * @throws Exception\ApiException if the API call fails
     *
     * @return Category
     */
    public function delete(Category $category)
    {
        // Endpoint URI
        $uri = sprintf('v1/categories/%d', $category->getId());

        try {
            $response = $this->httpClient->delete($uri);

            if ($this->cache) {
                $this->cache->delete($uri.'/'.$category->getId(), []);
            }

            return true;
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw Exception\ApiException::translate($responseBody, $responseCode);
        }

    }
}
