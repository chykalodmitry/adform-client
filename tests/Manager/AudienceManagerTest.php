<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Audiens\AdForm\Tests\Manager;

use Audiens\AdForm\Client;
use Audiens\AdForm\Entity\Audience;
use Audiens\AdForm\Entity\Segment;
use PHPUnit\Framework\TestCase;

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

        TestCase::assertNotEmpty($items);

        TestCase::assertInternalType('array', $items);

        TestCase::assertGreaterThan(0, \count($items));

        foreach($items as $item) {
            TestCase::assertInstanceOf(Audience::class, $item);
        }
    }

}
