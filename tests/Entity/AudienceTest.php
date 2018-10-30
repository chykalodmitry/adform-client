<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Audiens\AdForm\Tests\Entity;

use Audiens\AdForm\Entity\Audience;
use DateTime;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AudienceTest extends TestCase
{
    public function test_jsonSerializeWillProduceACorrectFullObject(): void
    {
        $time = new DateTime('now');

        $audience = new Audience();
        $audience->setDate($time);
        $audience->setSegmentId(Uuid::uuid4()->toString());
        $audience->setTotal(42);

        $obj = $audience->jsonSerialize();

        TestCase::assertObjectHasAttribute('date', $obj);
        TestCase::assertObjectHasAttribute('segmentId', $obj);
        TestCase::assertObjectHasAttribute('total', $obj);

        TestCase::assertEquals($audience->getSegmentId(), $obj->segmentId);
        TestCase::assertEquals($audience->getTotal(), $obj->total);
        TestCase::assertEquals($audience->getDate()->format('c'), $obj->date);
    }

    public function test_jsonSerializeWillProduceACorrectPartialObject(): void
    {
        $audience = new Audience();
        $audience->setTotal(42);

        $obj = $audience->jsonSerialize();

        TestCase::assertObjectHasAttribute('date', $obj);
        TestCase::assertObjectHasAttribute('segmentId', $obj);
        TestCase::assertObjectHasAttribute('total', $obj);

        TestCase::assertEquals($audience->getTotal(), $obj->total);
        TestCase::assertNull($obj->segmentId);
        TestCase::assertNull($obj->date);
    }
}
