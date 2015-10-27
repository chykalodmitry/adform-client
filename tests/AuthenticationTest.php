<?php

namespace Audiens\AdForm\Tests;

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
        $auth = new \Audiens\AdForm\Authentication(SANDBOX_USERNAME, SANDBOX_PASSWORD);

        $this->assertInstanceOf(\Audiens\AdForm\Authentication::class, $auth);

        $this->assertNotEmpty($auth->getAccessToken());
    }
}
