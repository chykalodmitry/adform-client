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

    /** @var  Autentication */
    protected $autentication;

    /** @var string */
    protected $username;

    /** @var string */
    protected $password;

    /**
     * @param array $config
     */
    public function __construct($username, $password, array $config = [])
    {
        $this->username = $username;
        $this->password = $password;

        parent::__construct($config);

    }

    protected function injectToken(&$options)
    {

        if ($this->autentication instanceof Autentication) {
            if ($this->autentication->getExpires() > new \DateTime('+10 seconds')) {
                $options['headers']['Authorization'] = 'Bearer '.$this->autentication->getAccessToken();
            }
        }

        $response = $this->post(
            'v1/token',
            [
                'form_params' => [
                    'grant_type' => 'password',
                    'username' => $this->username,
                    'password' => $this->password,
                ],
            ]
        );

        $this->autentication = Autentication::fromJson($response->getBody()->getContents());

        $options['headers']['Authorization'] = 'Bearer '.$this->autentication->getAccessToken();
    }

    /**
     * @param       $uri
     * @param array $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get($uri, array $options = [])
    {
        $this->injectToken($options);

        return parent::get($uri, $options);
    }


}
