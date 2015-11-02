<?php

namespace Audiens\AdForm\Tests\Provider;

use Audiens\AdForm\Client;
use Audiens\AdForm\Entity\Segment;
use Audiens\AdForm\Enum\SegmentStatus;

/**
 * Class SegmentProviderTest
 */
class SegmentProviderTest extends \PHPUnit_Framework_TestCase
{
    /** @var Client */
    private $client;

    private $fixtures = [];

    public function setUp()
    {
        $this->client = new Client(SANDBOX_USERNAME, SANDBOX_PASSWORD);
    }

    public function tearDown()
    {
        foreach ($this->fixtures as $fixture) {
            try {
                $this->client->segments()->delete($fixture);
            } catch (\Exception $e) {
                echo "Segment delete error: ".$e->getMessage()."\n";
            }
        }
    }

    private function getRandomName()
    {
        return 'Test'.substr(uniqid('', true), 0, 10);
    }

    private function createFixture($addTearDown = true)
    {
        $name = $this->getRandomName();

        $segment = new Segment();
        $segment->setName($name)
            ->setDataProviderId(SANDBOX_DATA_PROVIDER_ID)
            ->setStatus(new SegmentStatus('active'))
            ->setTtl(100)
            ->setCategoryId(377806)
            ->setFrequency(5)
            ->setRefId(strtolower($name))
            ->setFee(0.6);
        $segment = $this->client->segments()->create($segment);

        if ($addTearDown) {
            $this->fixtures[] = $segment;
        }

        return $segment;
    }

    /**
     * @test
     */
    public function getItemWillReturnInstanceOfSegment()
    {
        $segment = $this->createFixture();

        $segment = $this->client->segments()->getItem($segment->getId());

        $this->assertInstanceOf(Segment::class, $segment);
    }

    /**
     * @test
     */
    public function getItemsWillReturnArrayOfSegments()
    {
        $segments = $this->client->segments()->getItems(1);

        $this->assertInternalType('array', $segments);

        list($segment) = $segments;

        $this->assertInstanceOf(Segment::class, $segment);
    }

    /**
     * @test
     */
    public function getItemsDataProviderWillReturnArrayOfSegments()
    {
        $segments = $this->client->segments()->getItemsDataProvider(SANDBOX_DATA_PROVIDER_ID, 1);

        $this->assertInternalType('array', $segments);

        list($segment) = $segments;

        $this->assertInstanceOf(Segment::class, $segment);
    }


    /**
     * @test
     */
    public function getItemsCategoryWillReturnAnArrayOfSegments()
    {

        $categories = $this->client->categories()->getItemsDataProvider(SANDBOX_DATA_PROVIDER_ID,1);

        $segments = $this->client->segments()->getItemsCategory($categories[0]->getId(), 2);

        $this->assertInternalType('array', $segments);
        $this->assertNotEmpty($segments);

        list($segment) = $segments;

        $this->assertInstanceOf(Segment::class, $segment);
    }

    /**
     * @test
     */
    public function createWillReturnInstanceOfSegment()
    {
        $segment = $this->createFixture();

        $this->assertInstanceOf(Segment::class, $segment);
    }

    /**
     * @test
     */
    public function createWillThrowEntityInvalidException()
    {
        $this->setExpectedException('Audiens\AdForm\Exception\EntityInvalidException');

        $segment = new Segment();
        $segment = $this->client->segments()->create($segment);
    }

    /**
     * @test
     */
    public function updateWillReturnInstanceOfSegment()
    {
        $segment = $this->createFixture();

        $name = $this->getRandomName();
        $segment->setName($name);

        $segment = $this->client->segments()->update($segment);

        $this->assertInstanceOf(Segment::class, $segment);
        $this->assertEquals($segment->getName(), $name);
    }

    /**
     * @test
     */
    public function updateWillThrowEntityInvalidException()
    {
        $this->setExpectedException('Audiens\AdForm\Exception\EntityInvalidException');

        $segmentUnique = $this->createFixture();
        $segmentUpdate = $this->createFixture();
        $segmentUpdate->setRefId($segmentUnique->getRefId());

        $this->client->segments()->update($segmentUpdate);
    }

    /**
     * @test
     */
    public function deleteWillReturnTrue()
    {
        $segment = $this->createFixture(false);

        $status = $this->client->segments()->delete($segment);

        $this->assertTrue($status);
    }

    /**
     * @test
     */
    public function deleteWillThrowApiException()
    {
        $this->setExpectedException('Audiens\AdForm\Exception\ApiException');

        $segment = new Segment();

        $this->client->segments()->delete($segment);
    }
}
