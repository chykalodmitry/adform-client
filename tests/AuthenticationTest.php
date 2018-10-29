<?php

namespace Audiens\AdForm\Tests;

use Audiens\AdForm\Authentication;

/**
 * Class AuthenticationTest
 */
class AuthenticationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function autenticateWillReturnAnAuthenticationObject()
    {
        $auth = new Authentication(SANDBOX_USERNAME, SANDBOX_PASSWORD);

        $this->assertInstanceOf(Authentication::class, $auth);

        $this->assertNotEmpty($auth->getAccessToken());
    }
}
