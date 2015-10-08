<?php

namespace DMP\Tests;

use DMP\Autentication;
use DMP\OauthClient;

/**
 * Class OauthClient
 *
 * @package OauthClient
 */
class OauthClientTest extends \PHPUnit_Framework_TestCase
{

    const SANDBOX_USERNAME = '';
    const SANDBOX_PASSWORD = '';

    /**
     * @test
     */
    public function autenticate_will_return_an_autentication_object()
    {
        $oauthclient = new OauthClient();

        $autentication = $oauthclient->autenticate(self::SANDBOX_USERNAME, self::SANDBOX_PASSWORD);

        $this->assertInstanceOf(Autentication::class, $autentication);

    }


}
