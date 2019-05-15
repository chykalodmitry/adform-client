<?php 

namespace Tests\Manager;

use Audiens\AdForm\Client;
use DateTime;
use PHPUnit\Framework\TestCase;

class DataUsageManagerTest extends TestCase
{
    /** @var Client */
    private $client;

    public function setUp()
    {
        $this->client = new Client(SANDBOX_USERNAME, SANDBOX_PASSWORD);
    }

    public function test_geItemsWillReturnArray(): void
    {
        $from = new DateTime('yesterday');
        $to = new DateTime('today');
        $groupBy = ['segment'];
        $dataUsage = $this->client->dataUsage()->get(SANDBOX_DATA_PROVIDER_ID, $from, $to, $groupBy);

        TestCase::assertIsArray( $dataUsage);
    }
}
