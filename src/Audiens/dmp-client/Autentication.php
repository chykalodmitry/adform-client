<?php

namespace DMP;

/**
 * Class Autentication
 */
class Autentication
{

    protected $accessToken;

    protected $tokenType;

    protected $issued;

    protected $expires;

    protected $username;

    /**
     * Autentication constructor.
     *
     * @param $accessToken
     * @param $tokenType
     * @param $issued
     * @param $expires
     * @param $username
     */
    public function __construct($accessToken, $tokenType, $issued, $expires, $username)
    {
        $this->accessToken = $accessToken;
        $this->tokenType = $tokenType;
        $this->issued = $issued;
        $this->expires = $expires;
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return mixed
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * @return mixed
     */
    public function getIssued()
    {
        return $this->issued;
    }

    /**
     * @return mixed
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param $json
     *
     * @return Autentication
     */
    public static function fromJson($json)
    {

        $decoded = json_decode($json, false);

        if (!$accessToken = $decoded->access_token) {
            throw new \BadMethodCallException('missing access_token');
        }

        if (!$tokenType = $decoded->token_type) {
            throw new \BadMethodCallException('missing token_type');
        }

        if (!$decoded->expires_in) {
            throw new \BadMethodCallException('missing expires_in');
        }

        if (!$issued = $decoded->{'.issued'}) {
            throw new \BadMethodCallException('missing issued');
        }

        if (!$expires = $decoded->{'.expires'}) {
            throw new \BadMethodCallException('missing expires');
        }

        if (!$username = $decoded->userName) {
            throw new \BadMethodCallException('missing userName');
        }

        return new self(
            $accessToken,
            $tokenType,
            $issued,
            $expires,
            $username
        );


    }


}
