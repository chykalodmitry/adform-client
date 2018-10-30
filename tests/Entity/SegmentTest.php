<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Audiens\AdForm\Tests\Entity;

use Audiens\AdForm\Entity\Segment;
use Audiens\AdForm\Enum\SegmentStatus;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class SegmentTest extends TestCase
{
    public function test_jsonSerializeWillProduceACorrectFullObject(): void
    {
        $segment = new Segment();
        $segment
            ->setId(42)
            ->setName(Uuid::uuid4()->toString())
            ->setFee(0.42)
            ->setDataProviderId(24)
            ->setStatus(new SegmentStatus('active'))
            ->setAudience(true)
            ->setAudienceBySources([Uuid::uuid4()->toString()])
            ->setAudienceByUserIdentityType([Uuid::uuid4()->toString()])
            ->setExtensionThreshold(88)
            ->setExtractionRule('ex')
            ->setFormula('formula')
            ->setFrequency(55)
            ->setHasDataUsagePermissions(true)
            ->setIsCrossDevice(false)
            ->setIsExtended(true)
            ->setRefId(Uuid::uuid4()->toString())
            ->setTtl(55);

        $obj = $segment->jsonSerialize();

        TestCase::assertObjectHasAttribute('id', $obj);
        TestCase::assertObjectHasAttribute('dataProviderId', $obj);
        TestCase::assertObjectHasAttribute('status', $obj);
        TestCase::assertObjectHasAttribute('categoryId', $obj);
        TestCase::assertObjectHasAttribute('refId', $obj);
        TestCase::assertObjectHasAttribute('fee', $obj);
        TestCase::assertObjectHasAttribute('ttl', $obj);
        TestCase::assertObjectHasAttribute('name', $obj);
        TestCase::assertObjectHasAttribute('formula', $obj);
        TestCase::assertObjectHasAttribute('extractionRule', $obj);
        TestCase::assertObjectHasAttribute('audience', $obj);
        TestCase::assertObjectHasAttribute('audienceBySources', $obj);
        TestCase::assertObjectHasAttribute('audienceByUserIdentityType', $obj);
        TestCase::assertObjectHasAttribute('isExtended', $obj);
        TestCase::assertObjectHasAttribute('extensionThreshold', $obj);
        TestCase::assertObjectHasAttribute('frequency', $obj);
        TestCase::assertObjectHasAttribute('isCrossDevice', $obj);
        TestCase::assertObjectHasAttribute('hasDataUsagePermissions', $obj);
        // Only way to have this is via the hydrator
        TestCase::assertObjectNotHasAttribute('createdAt', $obj);
        TestCase::assertObjectNotHasAttribute('updatedAt', $obj);

        TestCase::assertEquals($segment->getId(), $obj->id);
        TestCase::assertEquals($segment->getDataProviderId(), $obj->dataProviderId);
        TestCase::assertEquals($segment->getStatus()->getValue(), $obj->status);
        TestCase::assertEquals($segment->getCategoryId(), $obj->categoryId);
        TestCase::assertEquals($segment->getRefId(), $obj->refId);
        TestCase::assertEquals($segment->getFee(), $obj->fee);
        TestCase::assertEquals($segment->getTtl(), $obj->ttl);
        TestCase::assertEquals($segment->getName(), $obj->name);
        TestCase::assertEquals($segment->getFormula(), $obj->formula);
        TestCase::assertEquals($segment->getExtractionRule(), $obj->extractionRule);
        TestCase::assertEquals($segment->getAudience(), $obj->audience);
        TestCase::assertEquals($segment->getAudienceBySources(), $obj->audienceBySources);
        TestCase::assertEquals($segment->getAudienceByUserIdentityType(), $obj->audienceByUserIdentityType);
        TestCase::assertEquals($segment->getIsExtended(), $obj->isExtended);
        TestCase::assertEquals($segment->getExtensionThreshold(), $obj->extensionThreshold);
        TestCase::assertEquals($segment->getFrequency(), $obj->frequency);
        TestCase::assertEquals($segment->getIsCrossDevice(), $obj->isCrossDevice);
        TestCase::assertEquals($segment->getHasDataUsagePermissions(), $obj->hasDataUsagePermissions);
    }

    public function test_jsonSerializeWillProduceACorrectPartialObject(): void
    {
        $segment = new Segment();
        $segment
            ->setId(42)
            ->setName(Uuid::uuid4()->toString())
            ->setFee(0.42)
            ->setDataProviderId(24)
            ->setAudience(true)
            ->setAudienceBySources([Uuid::uuid4()->toString()])
            ->setAudienceByUserIdentityType([Uuid::uuid4()->toString()])
            ->setFrequency(55)
            ->setHasDataUsagePermissions(true)
            ->setIsCrossDevice(false)
            ->setIsExtended(true)
            ->setRefId(Uuid::uuid4()->toString())
            ->setTtl(55);

        $obj = $segment->jsonSerialize();

        TestCase::assertObjectHasAttribute('id', $obj);
        TestCase::assertObjectHasAttribute('dataProviderId', $obj);
        TestCase::assertObjectHasAttribute('status', $obj);
        TestCase::assertObjectHasAttribute('categoryId', $obj);
        TestCase::assertObjectHasAttribute('refId', $obj);
        TestCase::assertObjectHasAttribute('fee', $obj);
        TestCase::assertObjectHasAttribute('ttl', $obj);
        TestCase::assertObjectHasAttribute('name', $obj);
        TestCase::assertObjectNotHasAttribute('formula', $obj);
        TestCase::assertObjectNotHasAttribute('extractionRule', $obj);
        TestCase::assertObjectHasAttribute('audience', $obj);
        TestCase::assertObjectHasAttribute('audienceBySources', $obj);
        TestCase::assertObjectHasAttribute('audienceByUserIdentityType', $obj);
        TestCase::assertObjectHasAttribute('isExtended', $obj);
        TestCase::assertObjectNotHasAttribute('extensionThreshold', $obj);
        TestCase::assertObjectHasAttribute('frequency', $obj);
        TestCase::assertObjectHasAttribute('isCrossDevice', $obj);
        TestCase::assertObjectHasAttribute('hasDataUsagePermissions', $obj);
        // Only way to have this is via the hydrator
        TestCase::assertObjectNotHasAttribute('createdAt', $obj);
        TestCase::assertObjectNotHasAttribute('updatedAt', $obj);

        TestCase::assertEquals($segment->getId(), $obj->id);
        TestCase::assertEquals($segment->getDataProviderId(), $obj->dataProviderId);
        TestCase::assertNull($obj->status);
        TestCase::assertEquals($segment->getCategoryId(), $obj->categoryId);
        TestCase::assertEquals($segment->getRefId(), $obj->refId);
        TestCase::assertEquals($segment->getFee(), $obj->fee);
        TestCase::assertEquals($segment->getTtl(), $obj->ttl);
        TestCase::assertEquals($segment->getName(), $obj->name);
        TestCase::assertEquals($segment->getAudience(), $obj->audience);
        TestCase::assertEquals($segment->getAudienceBySources(), $obj->audienceBySources);
        TestCase::assertEquals($segment->getAudienceByUserIdentityType(), $obj->audienceByUserIdentityType);
        TestCase::assertEquals($segment->getIsExtended(), $obj->isExtended);
        TestCase::assertEquals($segment->getFrequency(), $obj->frequency);
        TestCase::assertEquals($segment->getIsCrossDevice(), $obj->isCrossDevice);
        TestCase::assertEquals($segment->getHasDataUsagePermissions(), $obj->hasDataUsagePermissions);
    }
}
