<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Audiens\AdForm\Tests\Manager;

use Audiens\AdForm\Client;
use Audiens\AdForm\Entity\Agency;
use PHPUnit\Framework\TestCase;

class AgencyManagerTest extends TestCase
{
    /** @var Client */
    private $client;


    public function setUp()
    {
        $this->client = new Client(SANDBOX_USERNAME, SANDBOX_PASSWORD);
    }

    public function test_getItemWillReturnAnAgency(): void
    {
        $agencyId = '1'; //change this with a valid agency id

        if(!empty($agencyId)) {
            $agency = $this->client->agencies()->getItem($agencyId);

            TestCase::assertNotEmpty($agency);

            TestCase::assertInstanceOf(Agency::class, $agency);
        }
    }

    public function test_getItemsWillReturnArrayOfAgencies(): void
    {
        $agencies = $this->client->agencies()->getItems(1);

        TestCase::assertInternalType('array', $agencies);

        [$agency] = $agencies;

        TestCase::assertInstanceOf(Agency::class, $agency);
    }

    public function test_getItemsDataProviderWillReturnArrayOfAgencies(): void
    {
        $agencies = $this->client->agencies()->getItemsDataProvider(SANDBOX_DATA_PROVIDER_ID, 1);

        TestCase::assertInternalType('array', $agencies);

        [$agency] = $agencies;

        TestCase::assertInstanceOf(Agency::class, $agency);
    }
}
