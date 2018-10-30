<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Audiens\AdForm\Tests\Provider;

use Audiens\AdForm\Cache\CacheInterface;
use Audiens\AdForm\Client;
use Audiens\AdForm\Entity\Category;
use Audiens\AdForm\Entity\Segment;
use Audiens\AdForm\Enum\SegmentStatus;
use Audiens\AdForm\Exception\EntityInvalidException;
use Audiens\AdForm\HttpClient;
use Audiens\AdForm\Manager\SegmentManager;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Ramsey\Uuid\Uuid;
use Audiens\AdForm\Exception\ApiException;

class SegmentManagerTest extends TestCase
{
    /** @var Client */
    private $client;

    /** @var Segment[] */
    private $fixtures = [];

    /** @var Category[] */
    private $categoryFixtures = [];

    public function setUp()
    {
        $this->client = new Client(SANDBOX_USERNAME, SANDBOX_PASSWORD);
    }

    public function tearDown()
    {
        foreach ($this->fixtures as $segment) {
            try {
                $this->client->segments()->delete($segment);
            } catch (\Exception $e) {
                echo 'Segment delete error: ' .$e->getMessage()."\n";
            }
        }

        foreach ($this->categoryFixtures as $category) {
            try {
                $categorySegments = $this->client->segments()->getItemsCategory($category->getId());
                foreach ($categorySegments as $categorySegment) {
                    $this->client->segments()->delete($categorySegment);
                }
                $this->client->categories()->delete($category);
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

    private function createFixture($addTearDown = true, $taxonomyUnifiedLabelIds = []): Segment
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

        if (!empty($taxonomyUnifiedLabelIds)) {
            $segment->setUnifiedTaxonomyLabelIds($taxonomyUnifiedLabelIds);
        }

        $segment = $this->client->segments()->create($segment);

        if ($addTearDown) {
            $this->fixtures[] = $segment;
        }

        return $segment;
    }

    /**
     * @group unit
     */
    public function test_getItemWillReturnACachedSegment(): void
    {
        $originalSegment = $this->createFixture();

        /** @var CacheInterface|ObjectProphecy $cache */
        $cache = $this->prophesize(CacheInterface::class);
        $cache
            ->get('segment', 'v1/segments/'.$originalSegment->getId(), Argument::any())
            ->willReturn(\json_encode($originalSegment))->shouldBeCalledTimes(1);

        /** @var HttpClient|ObjectProphecy $httpClient */
        $httpClient = $this->prophesize(HttpClient::class);

        $segmentManager = new SegmentManager($httpClient->reveal(), $cache->reveal());
        $foundSegment = $segmentManager->getItem($originalSegment->getId());

        TestCase::assertJsonStringEqualsJsonString(
            \json_encode($originalSegment),
            \json_encode($foundSegment)
        );
    }

    /**
     * @group unit
     */
    public function test_getItemWillPutTheSegmentIntoTheCache(): void
    {
        $originalSegment = $this->createFixture();
        $encodedOriginalSegment = \json_encode($originalSegment);

        $uri = 'v1/segments/'.$originalSegment->getId();

        /** @var CacheInterface|ObjectProphecy $cache */
        $cache = $this->prophesize(CacheInterface::class);
        $cache
            ->get('segment', $uri, Argument::any())
            ->willReturn(null)->shouldBeCalledTimes(1);
        $cache
            ->put('segment', $uri, Argument::any(), $encodedOriginalSegment)
            ->shouldBeCalledTimes(1);

        /** @var StreamInterface|ObjectProphecy $responseBody */
        $responseBody = $this->prophesize(StreamInterface::class);
        $responseBody->getContents()->willReturn($encodedOriginalSegment);
        /** @var ResponseInterface|ObjectProphecy $response */
        $response = $this->prophesize(ResponseInterface::class);
        $response->getBody()->willReturn($responseBody);

        /** @var HttpClient|ObjectProphecy $httpClient */
        $httpClient = $this->prophesize(HttpClient::class);
        $httpClient
            ->get($uri)
            ->willReturn($response)
            ->shouldBeCalledTimes(1);

        $segmentManager = new SegmentManager($httpClient->reveal(), $cache->reveal());
        $foundSegment = $segmentManager->getItem($originalSegment->getId());

        TestCase::assertJsonStringEqualsJsonString(
            $encodedOriginalSegment,
            \json_encode($foundSegment)
        );
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

    /**
     * @group unit
     */
    public function test_getItemsWillReturnACachedResponse(): void
    {
        $originalSegment = $this->createFixture();

        /** @var CacheInterface|ObjectProphecy $cache */
        $cache = $this->prophesize(CacheInterface::class);
        $cache
            ->get('segment', 'v1/segments', Argument::any())
            ->willReturn(\json_encode([$originalSegment]))->shouldBeCalledTimes(1);

        /** @var HttpClient|ObjectProphecy $httpClient */
        $httpClient = $this->prophesize(HttpClient::class);

        $segmentManager = new SegmentManager($httpClient->reveal(), $cache->reveal());
        $foundSegments = $segmentManager->getItems();

        TestCase::assertJsonStringEqualsJsonString(
            \json_encode([$originalSegment]),
            \json_encode($foundSegments)
        );
    }

    /**
     * @group unit
     */
    public function test_getItemsWillPutTheSegmentsIntoTheCache(): void
    {
        $originalSegment = $this->createFixture();
        $encodedOriginalSegment = \json_encode([$originalSegment]);

        $uri = 'v1/segments';

        /** @var CacheInterface|ObjectProphecy $cache */
        $cache = $this->prophesize(CacheInterface::class);
        $cache
            ->get('segment', $uri, Argument::any())
            ->willReturn(null)->shouldBeCalledTimes(1);
        $cache
            ->put('segment', $uri, Argument::any(), $encodedOriginalSegment)
            ->shouldBeCalledTimes(1);

        /** @var StreamInterface|ObjectProphecy $responseBody */
        $responseBody = $this->prophesize(StreamInterface::class);
        $responseBody->getContents()->willReturn($encodedOriginalSegment);
        /** @var ResponseInterface|ObjectProphecy $response */
        $response = $this->prophesize(ResponseInterface::class);
        $response->getBody()->willReturn($responseBody);

        /** @var HttpClient|ObjectProphecy $httpClient */
        $httpClient = $this->prophesize(HttpClient::class);
        $httpClient
            ->get($uri, Argument::any())
            ->willReturn($response)
            ->shouldBeCalledTimes(1);

        $segmentManager = new SegmentManager($httpClient->reveal(), $cache->reveal());
        $foundSegments = $segmentManager->getItems();

        TestCase::assertJsonStringEqualsJsonString(
            $encodedOriginalSegment,
            \json_encode($foundSegments)
        );
    }

    public function test_getItemsDataProviderWillReturnArrayOfSegments(): void
    {
        $segments = $this->client->segments()->getItemsDataProvider(SANDBOX_DATA_PROVIDER_ID, 1);

        TestCase::assertInternalType('array', $segments);

        [$segment] = $segments;

        TestCase::assertInstanceOf(Segment::class, $segment);
    }

    /**
     * @group unit
     */
    public function test_getItemsDataProviderWillReturnACachedResponse(): void
    {
        $dataProviderId = 42;
        $uri = "v1/dataproviders/$dataProviderId/segments";

        $originalSegment = $this->createFixture();

        /** @var CacheInterface|ObjectProphecy $cache */
        $cache = $this->prophesize(CacheInterface::class);
        $cache
            ->get('segment', $uri, Argument::any())
            ->willReturn(\json_encode([$originalSegment]))->shouldBeCalledTimes(1);

        /** @var HttpClient|ObjectProphecy $httpClient */
        $httpClient = $this->prophesize(HttpClient::class);

        $segmentManager = new SegmentManager($httpClient->reveal(), $cache->reveal());
        $foundSegments = $segmentManager->getItemsDataProvider($dataProviderId);

        TestCase::assertJsonStringEqualsJsonString(
            \json_encode([$originalSegment]),
            \json_encode($foundSegments)
        );
    }

    /**
     * @group unit
     */
    public function test_getItemsDataProviderWillPutTheSegmentsIntoTheCache(): void
    {
        $originalSegment = $this->createFixture();
        $encodedOriginalSegment = \json_encode([$originalSegment]);

        $dataProviderId = 42;
        $uri = "v1/dataproviders/$dataProviderId/segments";

        /** @var CacheInterface|ObjectProphecy $cache */
        $cache = $this->prophesize(CacheInterface::class);
        $cache
            ->get('segment', $uri, Argument::any())
            ->willReturn(null)->shouldBeCalledTimes(1);
        $cache
            ->put('segment', $uri, Argument::any(), $encodedOriginalSegment)
            ->shouldBeCalledTimes(1);

        /** @var StreamInterface|ObjectProphecy $responseBody */
        $responseBody = $this->prophesize(StreamInterface::class);
        $responseBody->getContents()->willReturn($encodedOriginalSegment);
        /** @var ResponseInterface|ObjectProphecy $response */
        $response = $this->prophesize(ResponseInterface::class);
        $response->getBody()->willReturn($responseBody);

        /** @var HttpClient|ObjectProphecy $httpClient */
        $httpClient = $this->prophesize(HttpClient::class);
        $httpClient
            ->get($uri, Argument::any())
            ->willReturn($response)
            ->shouldBeCalledTimes(1);

        $segmentManager = new SegmentManager($httpClient->reveal(), $cache->reveal());
        $foundSegments = $segmentManager->getItemsDataProvider($dataProviderId);

        TestCase::assertJsonStringEqualsJsonString(
            $encodedOriginalSegment,
            \json_encode($foundSegments)
        );
    }

    /**
     * @group unit
     */
    public function test_getItemsCategoryWillReturnACachedResponse(): void
    {
        $categoryId = 42;
        $uri = "v1/categories/$categoryId/segments";

        $originalSegment = $this->createFixture();

        /** @var CacheInterface|ObjectProphecy $cache */
        $cache = $this->prophesize(CacheInterface::class);
        $cache
            ->get('segment', $uri, Argument::any())
            ->willReturn(\json_encode([$originalSegment]))->shouldBeCalledTimes(1);

        /** @var HttpClient|ObjectProphecy $httpClient */
        $httpClient = $this->prophesize(HttpClient::class);

        $segmentManager = new SegmentManager($httpClient->reveal(), $cache->reveal());
        $foundSegments = $segmentManager->getItemsCategory($categoryId);

        TestCase::assertJsonStringEqualsJsonString(
            \json_encode([$originalSegment]),
            \json_encode($foundSegments)
        );
    }

    /**
     * @group unit
     */
    public function test_getItemsCategoryWillPutTheSegmentsIntoTheCache(): void
    {
        $originalSegment = $this->createFixture();
        $encodedOriginalSegment = \json_encode([$originalSegment]);

        $categoryId = 42;
        $uri = "v1/categories/$categoryId/segments";

        /** @var CacheInterface|ObjectProphecy $cache */
        $cache = $this->prophesize(CacheInterface::class);
        $cache
            ->get('segment', $uri, Argument::any())
            ->willReturn(null)->shouldBeCalledTimes(1);
        $cache
            ->put('segment', $uri, Argument::any(), $encodedOriginalSegment)
            ->shouldBeCalledTimes(1);

        /** @var StreamInterface|ObjectProphecy $responseBody */
        $responseBody = $this->prophesize(StreamInterface::class);
        $responseBody->getContents()->willReturn($encodedOriginalSegment);
        /** @var ResponseInterface|ObjectProphecy $response */
        $response = $this->prophesize(ResponseInterface::class);
        $response->getBody()->willReturn($responseBody);

        /** @var HttpClient|ObjectProphecy $httpClient */
        $httpClient = $this->prophesize(HttpClient::class);
        $httpClient
            ->get($uri, Argument::any())
            ->willReturn($response)
            ->shouldBeCalledTimes(1);

        $segmentManager = new SegmentManager($httpClient->reveal(), $cache->reveal());
        $foundSegments = $segmentManager->getItemsCategory($categoryId);

        TestCase::assertJsonStringEqualsJsonString(
            $encodedOriginalSegment,
            \json_encode($foundSegments)
        );
    }

    /**
     * @group unit
     */
    public function test_getItemsDataConsumerWillReturnACachedResponse(): void
    {
        $dataConsumerId = 42;
        $uri = "v1/dataconsumers/$dataConsumerId/segments";

        $originalSegment = $this->createFixture();

        /** @var CacheInterface|ObjectProphecy $cache */
        $cache = $this->prophesize(CacheInterface::class);
        $cache
            ->get('segment', $uri, Argument::any())
            ->willReturn(\json_encode([$originalSegment]))->shouldBeCalledTimes(1);

        /** @var HttpClient|ObjectProphecy $httpClient */
        $httpClient = $this->prophesize(HttpClient::class);

        $segmentManager = new SegmentManager($httpClient->reveal(), $cache->reveal());
        $foundSegments = $segmentManager->getItemsDataConsumer($dataConsumerId);

        TestCase::assertJsonStringEqualsJsonString(
            \json_encode([$originalSegment]),
            \json_encode($foundSegments)
        );
    }

    /**
     * @group unit
     */
    public function test_getItemsDataConsumerWillPutTheSegmentsIntoTheCache(): void
    {
        $originalSegment = $this->createFixture();
        $encodedOriginalSegment = \json_encode([$originalSegment]);

        $dataConsumerId = 42;
        $uri = "v1/dataconsumers/$dataConsumerId/segments";

        /** @var CacheInterface|ObjectProphecy $cache */
        $cache = $this->prophesize(CacheInterface::class);
        $cache
            ->get('segment', $uri, Argument::any())
            ->willReturn(null)->shouldBeCalledTimes(1);
        $cache
            ->put('segment', $uri, Argument::any(), $encodedOriginalSegment)
            ->shouldBeCalledTimes(1);

        /** @var StreamInterface|ObjectProphecy $responseBody */
        $responseBody = $this->prophesize(StreamInterface::class);
        $responseBody->getContents()->willReturn($encodedOriginalSegment);
        /** @var ResponseInterface|ObjectProphecy $response */
        $response = $this->prophesize(ResponseInterface::class);
        $response->getBody()->willReturn($responseBody);

        /** @var HttpClient|ObjectProphecy $httpClient */
        $httpClient = $this->prophesize(HttpClient::class);
        $httpClient
            ->get($uri, Argument::any())
            ->willReturn($response)
            ->shouldBeCalledTimes(1);

        $segmentManager = new SegmentManager($httpClient->reveal(), $cache->reveal());
        $foundSegments = $segmentManager->getItemsDataConsumer($dataConsumerId);

        TestCase::assertJsonStringEqualsJsonString(
            $encodedOriginalSegment,
            \json_encode($foundSegments)
        );
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

    public function test_deleteWillThrowApiException(): void
    {
        $this->expectException(ApiException::class);

        $segment = new Segment();

        $this->client->segments()->delete($segment);
    }

    public function test_createWillSaveTheUnifiedTaxonomyLabelIds(): void
    {
        $unifiedTaxonomyLabelIds = [1, 2, 3];
        $segment = $this->createFixture(false, $unifiedTaxonomyLabelIds);
        TestCase::assertNotNull(
            $segment->getId(),
            'Giving the taxonomy label ids should, create should save without errors'
        );

        TestCase::assertEquals(
            $unifiedTaxonomyLabelIds,
            $segment->getUnifiedTaxonomyLabelIds(),
            'Giving the taxonomy label ids should, create should persist the data'
        );
    }

    public function test_updateWillSaveTheUnifiedTaxonomyLabelIds(): void
    {
        $unifiedTaxonomyLabelIds = [1, 2, 3];
        $addedUnifiedTaxonomyLabelIds = [4, 5];
        $extendedUnifiedTaxonomyLabelIds = \array_merge($unifiedTaxonomyLabelIds, $addedUnifiedTaxonomyLabelIds);

        $segment = $this->createFixture(false, $unifiedTaxonomyLabelIds);

        // Add new label ids
        foreach ($addedUnifiedTaxonomyLabelIds as $unifiedTaxonomyLabelId) {
            $segment->addUnifiedTaxonomyLabelId($unifiedTaxonomyLabelId);
        }
        $segment = $this->client->segments()->update($segment);
        TestCase::assertEquals(
            $extendedUnifiedTaxonomyLabelIds,
            $segment->getUnifiedTaxonomyLabelIds(),
            'Adding new taxonomy label ids, the client should preserve the old ones, too'
        );

        // Remove a label id
        array_pop($extendedUnifiedTaxonomyLabelIds);
        $segment->setUnifiedTaxonomyLabelIds($extendedUnifiedTaxonomyLabelIds);
        $segment = $this->client->segments()->update($segment);
        TestCase::assertEquals(
            $extendedUnifiedTaxonomyLabelIds,
            $segment->getUnifiedTaxonomyLabelIds(),
            'Setting a new taxonomy label id list, the client should not preserve the old ones'
        );
    }
}
