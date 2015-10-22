<?php

namespace Audiens\AdForm;

use Audiens\AdForm\Entities\Category;
use Audiens\AdForm\Entities\CategoryHydrator;
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
     * Constructor.
     *
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
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
            $response = $this->httpClient->get($uri);

            return CategoryHydrator::fromStdClass(json_decode($response->getBody()->getContents()));
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw new Exception\EntityNotFoundException($responseBody, $responseCode);
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
            $response = $this->httpClient->get($uri, $options);

            $classArray = json_decode($response->getBody()->getContents());

            foreach ($classArray as $class) {
                $categories[] = CategoryHydrator::fromStdClass($class);
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw new Exception\ApiException($responseBody, $responseCode);
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
            $response = $this->httpClient->get($uri, $options);

            $classArray = json_decode($response->getBody()->getContents());

            foreach ($classArray as $class) {
                $categories[] = CategoryHydrator::fromStdClass($class);
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw new Exception\ApiException($responseBody, $responseCode);
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
            $response = $this->httpClient->get($uri, $options);

            $classArray = json_decode($response->getBody()->getContents());

            foreach ($classArray as $class) {
                $categories[] = CategoryHydrator::fromStdClass($class);
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw new Exception\ApiException($responseBody, $responseCode);
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
            $response = $this->httpClient->post($uri, $options);

            return CategoryHydrator::fromStdClass(json_decode($response->getBody()->getContents()));
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            $error = json_decode($responseBody);

            if (property_exists($error, 'modelState')) { // validation error
                throw new Exception\EntityInvalidException($responseBody, $responseCode, $error->modelState);
            } else { // general error
                throw new Exception\ApiException($responseBody, $responseCode);
            }
        }

        return false;
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
            $response = $this->httpClient->put($uri, $options);

            return CategoryHydrator::fromStdClass(json_decode($response->getBody()->getContents()));
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            $error = json_decode($responseBody);

            if (property_exists($error, 'modelState')) { // validation error
                throw new Exception\EntityInvalidException($responseBody, $responseCode, $error->modelState);
            } else { // general error
                throw new Exception\ApiException($responseBody, $responseCode);
            }
        }

        return false;
    }

    /**
     * Delete a category
     *
     * @param Category $category
     *
     * @throws ApiException if the API call fails
     *
     * @return Category
     */
    public function delete(Category $category)
    {
        // Endpoint URI
        $uri = sprintf('v1/categories/%d', $category->getId());

        try {
            $response = $this->httpClient->delete($uri);

            return true;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            $responseCode = $response->getStatusCode();

            throw new Exception\ApiException($responseBody, $responseCode);
        }

        return false;
    }
}
