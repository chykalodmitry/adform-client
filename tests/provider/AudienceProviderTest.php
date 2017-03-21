<?php

namespace Audiens\AdForm\Tests\Provider;

use Audiens\AdForm\Client;
use Audiens\AdForm\Entity\Audience;
use Audiens\AdForm\Entity\Segment;


/**
 * Class AudienceProviderTest
 */
class AudienceProviderTest extends \PHPUnit_Framework_TestCase
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
    public function getItemWillReturnArrayOfAudiences()
    {
        /** @var Segment $segment */
        $segment = $this->client->segments()->getItems(1)[0];

        $this->assertNotNull($segment);

        $items = $this->client->audience()->getItem($segment->getId());

        $this->assertNotEmpty($items);

        $this->assertInternalType('array', $items);

        $this->assertGreaterThan(0, count($items));

        foreach($items as $item)
        {
            $this->assertInstanceOf(Audience::class, $item);
        }
    }

}