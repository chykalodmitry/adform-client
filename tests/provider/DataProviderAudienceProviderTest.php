<?php

namespace Audiens\AdForm\Tests\Provider;

use Audiens\AdForm\Client;
use Audiens\AdForm\Entity\DataProviderAudience;

/**
 * Class AudienceProviderTest
 */
class DataProviderAudienceProviderTest extends \PHPUnit_Framework_TestCase
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
    public function geItemsWillReturnArrayOfDataProviderAudiences()
    {
        $from = new \DateTime('last monday');
        $to = new \DateTime('last tuesday');
        $groupBy = ['segment'];
        $dataProviderAudiences = $this->client->dataProviderAudience()->get(SANDBOX_DATA_PROVIDER_ID, $from, $to, $groupBy);

        $this->assertInternalType('array', $dataProviderAudiences);

        list($dataProviderAudience) = $dataProviderAudiences;

        $this->assertInstanceOf(DataProviderAudience::class, $dataProviderAudience);
    }
}
