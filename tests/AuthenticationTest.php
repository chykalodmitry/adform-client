<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Audiens\AdForm\Tests;

use Audiens\AdForm\Authentication;
use PHPUnit\Framework\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_authenticateWillReturnAnAuthenticationObject(): void
    {
        $auth = new Authentication(SANDBOX_USERNAME, SANDBOX_PASSWORD);

        TestCase::assertInstanceOf(Authentication::class, $auth);

        TestCase::assertNotEmpty($auth->getAccessToken());
    }
}
