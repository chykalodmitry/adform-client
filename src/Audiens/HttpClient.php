<?php

namespace Audiens\AdForm;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

class HttpClient
{
    /** @var Authentication */
    protected $authentication;

    /** @var GuzzleClient */
    protected $guzzle;

    /** @var string */
    protected $accessToken = null;

    public function __construct($authentication, array $config = [])
    {
        $this->authentication = $authentication;

        $this->guzzle = new GuzzleClient(
            [
                'debug' => $config['debug'] ?? false,
                'base_uri' => Client::BASE_URL,
                'headers' => [
                    'User-Agent' => 'Audiens',
                    'Accept' => 'application/json',
                    'Content-type' => 'application/json',
                ],
            ]
        );
    }

    public function get(string $uri, array $options = []): ResponseInterface
    {
        return $this->request('GET', $uri, $options);
    }

    public function post(string $uri, array $options = []): ResponseInterface
    {
        return $this->request('POST', $uri, $options);
    }

    public function put(string $uri, array $options = []): ResponseInterface
    {
        return $this->request('PUT', $uri, $options);
    }

    public function delete(string $uri, array $options = []): ResponseInterface
    {
        return $this->request('DELETE', $uri, $options);
    }

    /**
     * Performs the actual request on the Guzzle instance
     * also injects the Oauth2 Access Token for each request
     */
    public function request(string $method, string $uri, array $options = []): ResponseInterface
    {
        $options['headers']['Authorization'] = 'Bearer '.$this->authentication->getAccessToken(); // Inject Oauth2 Access Token on each request if it expires try to re-authenticate

        return $this->guzzle->request($method, $uri, $options);
    }
}
