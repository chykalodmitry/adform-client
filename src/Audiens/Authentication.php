<?php declare(strict_types=1);

namespace Audiens\AdForm;

use Audiens\AdForm\Exception\OauthException;
use DateTime;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessToken;

class Authentication
{
    /** @var AccessToken|null */
    protected $accessToken;

    /** @var string */
    protected $username;

    /** @var string */
    protected $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Authenticate on AdForm API using the password grant
     *
     * @throws OauthException if authentication fails
     */
    public function authenticate(): void
    {
        $urlAccessToken = Client::BASE_URL.'/v1/token';

        // we are using a very simple password grant
        // AdForm doesn't even return a Refresh Token
        $provider = new GenericProvider(
            [
                'clientId' => '',
                'clientSecret' => '',
                'redirectUri' => '',
                'urlAuthorize' => '',
                'urlAccessToken' => $urlAccessToken,
                'urlResourceOwnerDetails' => '',
            ]
        );

        try {
            $this->accessToken = $provider->getAccessToken(
                'password',
                [
                    'username' => $this->username,
                    'password' => $this->password,
                ]
            );
        } catch (IdentityProviderException $e) {
            throw OauthException::connect($e->getMessage());
        }
    }

    /**
     * Returns the Access Token, or try to re-authenticate if needed
     */
    public function getAccessToken(): string
    {
        $expiryCutoff = new DateTime('+10 seconds'); // Maybe the token will expire in next 10 seconds

        if (!$this->accessToken || $this->getExpires() < $expiryCutoff->getTimestamp()) {
            $this->authenticate(); // If the token expires try to re-authenticate
        }

        if (!$this->accessToken) {
            throw OauthException::connect('Cannot authenticate, token is null after request');
        }

        return $this->accessToken->getToken();
    }

    /**
     * Returns the Expires timestamp of the Access Token
     */
    public function getExpires(): ?int
    {
        if (!$this->accessToken) {
            throw OauthException::connect('Cannot extract Expires as the token is empty');
        }

        return $this->accessToken->getExpires();
    }
}
