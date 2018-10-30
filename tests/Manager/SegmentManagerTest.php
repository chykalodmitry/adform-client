<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Audiens\AdForm\Tests\Provider;

use Audiens\AdForm\Client;
use Audiens\AdForm\Entity\Category;
use Audiens\AdForm\Entity\Segment;
use Audiens\AdForm\Enum\SegmentStatus;
use Audiens\AdForm\Exception\EntityInvalidException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Audiens\AdForm\Exception\ApiException;

/**
 * Class SegmentProviderTest
 */
class SegmentManagerTest extends TestCase
{
    /** @var Client */
    private $client;

    private $fixtures = [];

    private $categoryFixtures = [];

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
                echo 'Segment delete error: ' .$e->getMessage()."\n";
            }
        }

        foreach ($this->categoryFixtures as $fixture) {
            try {
                $this->client->categories()->delete($fixture);
            } catch (\Exception $e) {
                echo 'Category delete error: ' .$e->getMessage()."\n";
            }
        }

    }

    private function createCategoryFixture($addTearDown = true): Category
    {
        $category = new Category();
        $category->setName(Uuid::uuid4()->toString())
            ->setDataProviderId(SANDBOX_DATA_PROVIDER_ID);
        $category = $this->client->categories()->create($category);

        if ($addTearDown) {
            $this->categoryFixtures[] = $category;
        }

        return $category;
    }

    private function createFixture($addTearDown = true): Segment
    {
        $name = Uuid::uuid4()->toString();

        $category = $this->createCategoryFixture();

        $segment = new Segment();
        $segment->setName($name)
            ->setDataProviderId(SANDBOX_DATA_PROVIDER_ID)
            ->setStatus(new SegmentStatus('active'))
            ->setTtl(100)
            ->setCategoryId($category->getId())
            ->setFrequency(5)
            ->setRefId(strtolower($name))
            ->setFee(0.6);
        $segment = $this->client->segments()->create($segment);

        if ($addTearDown) {
            $this->fixtures[] = $segment;
        }

        return $segment;
    }

    public function test_getItemWillReturnInstanceOfSegment(): void
    {
        $segment = $this->createFixture();

        $segment = $this->client->segments()->getItem($segment->getId());

        TestCase::assertInstanceOf(Segment::class, $segment);
    }

    public function test_getItemsWillReturnArrayOfSegments(): void
    {
        $segments = $this->client->segments()->getItems(1);

        TestCase::assertInternalType('array', $segments);

        [$segment] = $segments;

        TestCase::assertInstanceOf(Segment::class, $segment);
    }

    public function test_getItemsDataProviderWillReturnArrayOfSegments(): void
    {
        $segments = $this->client->segments()->getItemsDataProvider(SANDBOX_DATA_PROVIDER_ID, 1);

        TestCase::assertInternalType('array', $segments);

        [$segment] = $segments;

        TestCase::assertInstanceOf(Segment::class, $segment);
    }


    public function test_getItemsCategoryWillReturnAnArrayOfSegments(): void
    {
        $segment = $this->createFixture();
        $segments = $this->client->segments()->getItemsCategory($segment->getCategoryId(), 2);

        TestCase::assertInternalType('array', $segments);
        TestCase::assertGreaterThanOrEqual(1, \count($segments));

        [$segmentCheck] = $segments;

        TestCase::assertInstanceOf(Segment::class, $segmentCheck);
    }

    public function test_createWillThrowEntityInvalidException(): void
    {
        $this->expectException(EntityInvalidException::class);

        $segment = new Segment();
        $this->client->segments()->create($segment);
    }

    public function test_updateWillReturnInstanceOfSegment(): void
    {
        $segment = $this->createFixture();

        $name = Uuid::uuid4()->toString();
        $segment->setName($name);

        $segment = $this->client->segments()->update($segment);

        TestCase::assertInstanceOf(Segment::class, $segment);
        TestCase::assertEquals($segment->getName(), $name);
    }

    public function test_updateWillThrowEntityInvalidException(): void
    {
        $this->expectException(EntityInvalidException::class);

        $segmentUnique = $this->createFixture();
        $segmentUpdate = $this->createFixture();
        $segmentUpdate->setRefId($segmentUnique->getRefId());

        $this->client->segments()->update($segmentUpdate);
    }

    public function test_deleteWillReturnTrue(): void
    {
        $segment = $this->createFixture(false);

        $status = $this->client->segments()->delete($segment);

        TestCase::assertTrue($status);
    }

    /**
     * @test
     */
    public function test_deleteWillThrowApiException(): void
    {
        $this->expectException(ApiException::class);

        $segment = new Segment();

        $this->client->segments()->delete($segment);
    }
}
