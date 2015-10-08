<?php

namespace DMP;

use GuzzleHttp\Client;

/**
 * Class OauthClient
 *
 * @package OauthClient
 */
class OauthClient extends Client
{

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {

        $config = [
            'debug' => true,
            'base_uri' => 'https://dmp-api.adform.com',
            'timeout' => 2.0,
            'headers' => [
                'User-Agent' => 'Audiens',
                'Accept' => 'application/json',
            ],
        ];

        parent::__construct($config);

    }

    /**
     *
     */
    public function autenticate($username, $password){

        $response = $this->post('v1/token', [
            'form_params' => [
                'grant_type' => 'password',
                'username' => $username,
                'password' => $password,
            ]
        ]);

        return Autentication::fromJson($response->getBody()->getContents());

    }

}
