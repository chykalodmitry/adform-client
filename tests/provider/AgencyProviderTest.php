<?php

namespace Audiens\AdForm\Tests\Provider;

use Audiens\AdForm\Client;
use Audiens\AdForm\Entity\Agency;
use Audiens\AdForm\Entity\Segment;
use Audiens\AdForm\Enum\SegmentStatus;

/**
 * Class AgencyProviderTest
 */
class AgencyProviderTest extends \PHPUnit_Framework_TestCase
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
    public function getItemWillReturnAnAgency()
    {
        $agencyId = 1; //change this with a valid agency id

        if(!empty($agencyId)) {
            $agency = $this->client->agencies()->getItem($agencyId);

            $this->assertNotEmpty($agency);

            $this->assertInstanceOf(Agency::class, $agency);
        }
    }

    /**
     * @test
     */
    public function getItemsWillReturnArrayOfAgencies()
    {
        $agencies = $this->client->agencies()->getItems(1);

        $this->assertInternalType('array', $agencies);

        list($agency) = $agencies;

        $this->assertInstanceOf(Agency::class, $agency);
    }

    /**
     * @test
     */
    public function getItemsDataProviderWillReturnArrayOfAgencies()
    {
        $agencies = $this->client->agencies()->getItemsDataProvider(SANDBOX_DATA_PROVIDER_ID, 1);

        $this->assertInternalType('array', $agencies);

        list($agency) = $agencies;

        $this->assertInstanceOf(Agency::class, $agency);
    }
}
