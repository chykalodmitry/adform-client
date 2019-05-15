<?php 

namespace Tests\Manager;

use Audiens\AdForm\Client;
use Audiens\AdForm\Entity\DataProviderAudience;
use DateTime;
use PHPUnit\Framework\TestCase;

class DataProviderAudienceManagerTest extends TestCase
{
    /** @var Client */
    private $client;

    public function setUp()
    {
        $this->client = new Client(SANDBOX_USERNAME, SANDBOX_PASSWORD);
    }

    public function test_geItemsWillReturnArrayOfDataProviderAudiences(): void
    {
        $from = new DateTime('last monday');
        $to = new DateTime('last tuesday');
        $groupBy = ['segment'];
        $dataProviderAudiences = $this->client->dataProviderAudience()->get(SANDBOX_DATA_PROVIDER_ID, $from, $to, $groupBy);

        TestCase::assertIsArray( $dataProviderAudiences);

        if (\count($dataProviderAudiences) > 0) {
            [$dataProviderAudience] = $dataProviderAudiences;

            TestCase::assertInstanceOf(DataProviderAudience::class, $dataProviderAudience);
        }
    }
}
