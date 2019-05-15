<?php 

namespace Tests\Entity;

use Audiens\AdForm\Entity\Segment;
use Audiens\AdForm\Entity\SegmentHydrator;
use PHPUnit\Framework\TestCase;
use stdClass;

class SegmentHydratorTest extends TestCase
{
    public function test_hydratorWillReturnSegmentObject(): void
    {
        $stdClass = new stdClass();
        $stdClass->id = 10;
        $stdClass->dataProviderId = 10000;
        $stdClass->status = 'active';
        $stdClass->categoryId = 20000;
        $stdClass->refId = 'test';
        $stdClass->fee = 0.7;
        $stdClass->ttl = 3600;
        $stdClass->name = 'Test';

        $stdClass->audience = true;
        $stdClass->audienceBySources = [];
        $stdClass->audienceByUserIdentityType = [];
        $stdClass->isExtended = true;

        $stdClass->frequency = 5;
        $stdClass->isCrossDevice = true;
        $stdClass->hasDataUsagePermissions = true;

        $stdClass->createdAt = '2015-10-10';
        $stdClass->updatedAt = '2015-10-10';

        $segment = SegmentHydrator::fromStdClass($stdClass);

        TestCase::assertInstanceOf(Segment::class, $segment);
    }
}
