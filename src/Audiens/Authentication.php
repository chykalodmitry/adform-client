<?php declare(strict_types=1);

namespace Audiens\AdForm;

use Audiens\AdForm\Exception\OauthException;
use Audiens\AdForm\Provider\AdformProvider;
use DateTime;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;

class Authentication
{
    /** @var string  */
    public const AUTH_URL = 'https://id.adform.com/sts/connect/token';

    /** @var AccessToken|null */
    protected $accessToken;

    /** @var string */
    protected $client_id;

    /** @var string */
    protected $client_secret;

    protected $scopes;

    public function __construct(string $client_id, string $client_secret, $scopes)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->scopes = $scopes;
    }

    /**
     * Authenticate on AdForm API using the password grant
     *
     * @throws OauthException if authentication fails
     */
    public function authenticate(): void
    {
        $urlAccessToken = self::AUTH_URL;

        // we are using a very simple password grant
        // AdForm doesn't even return a Refresh Token
        $provider = new AdformProvider(
            [
                'clientId' => $this->client_id,
                'clientSecret' => $this->client_secret,
                'redirectUri' => '',
                'urlAuthorize' => '',
                'urlAccessToken' => $urlAccessToken,
                'urlResourceOwnerDetails' => '',
                'scopes' => $this->scopes,
                'scopeSeparator' => ' '
            ]
        );

        try {
            $this->accessToken = $provider->getAccessToken('client_credentials');
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
