<?php

namespace Tests\Manager;

use Audiens\AdForm\Client;
use Audiens\AdForm\Entity\Audience;
use Audiens\AdForm\Entity\Segment;
use Audiens\AdForm\HttpClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class AudienceManagerTest extends TestCase
{
    /** @var Client */
    private $client;

    public function setUp()
    {
        $this->client = new Client(SANDBOX_USERNAME, SANDBOX_PASSWORD);
    }

    public function test_getItemWillReturnArrayOfAudiences(): void
    {
        /** @var Segment $segment */
        $segment = $this->client->segments()->getItems(1)[0];

        TestCase::assertNotNull($segment);

        $items = $this->client->audience()->getItem($segment->getId());

        TestCase::assertIsArray( $items);
        
    }

}
