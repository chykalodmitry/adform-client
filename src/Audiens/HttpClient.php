<?php

namespace Audiens\AdForm;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception;

/**
 * Class OauthClient
 *
 * @package OauthClient
 */
class HttpClient
{
    /**
     * @var Authentication.
     */
    protected $authentication;

    /**
     * @param Authentication $authentication
     * @param array $config
     */
    public function __construct($authentication, array $config = [])
    {
        $this->authentication = $authentication;

        // Guzzle
        $this->guzzle = new GuzzleClient([
            'debug' => isset($config['debug']) ? $config['debug'] : false,
            'base_uri' => Client::BASE_URL,
            'headers' => [
                'User-Agent' => 'Audiens',
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
            ],
        ]);
    }

    /**
     * GET request
     *
     * @param string $uri
     * @param array $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get($uri, array $options = [])
    {
        return $this->request('GET', $uri, $options);
    }

    /**
     * POST request
     *
     * @param string $uri
     * @param array $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function post($uri, array $options = [])
    {
        return $this->request('POST', $uri, $options);
    }

    /**
     * PUT request
     *
     * @param string $uri
     * @param array $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function put($uri, array $options = [])
    {
        return $this->request('PUT', $uri, $options);
    }

    /**
     * DELETE request
     *
     * @param string $uri
     * @param array $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete($uri, array $options = [])
    {
        return $this->request('DELETE', $uri, $options);
    }

    /**
     * Performs the actual request on the Guzzle instance
     * also injects the Oauth2 Access Token for each request
     *
     * @param string $method
     * @param string $uri
     * @param array $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function request($method, $uri, array $options = [])
    {
        // inject Oauth2 Access Token on each request
        // if it expires try to reauthenticate
        $options['headers']['Authorization'] = 'Bearer '.$this->authentication->getAccessToken();

        return $this->guzzle->request($method, $uri, $options);
    }
}
