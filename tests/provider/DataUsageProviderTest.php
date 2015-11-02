<?php

namespace Audiens\AdForm\Tests\Provider;

use Audiens\AdForm\Client;

/**
 * Class DataUsageProviderTest
 */
class DataUsageProviderTest extends \PHPUnit_Framework_TestCase
{
    /** @var Client */
    private $client;

    public function setUp()
    {
        $this->client = new Client(SANDBOX_USERNAME, SANDBOX_PASSWORD);
    }

    /**
     * @test
     */
    public function geItemsWillReturnArray()
    {
        $from = new \DateTime('yesterday');
        $to = new \DateTime('today');
        $groupBy = ['segment'];
        $dataUsage = $this->client->dataUsage()->get(SANDBOX_DATA_PROVIDER_ID, $from, $to, $groupBy);

        $this->assertInternalType('array', $dataUsage);
    }
}
