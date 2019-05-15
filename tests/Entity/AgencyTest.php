<?php 

namespace Tests\Entity;

use Audiens\AdForm\Entity\Agency;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AgencyTest extends TestCase
{
    public function test_jsonSerializeWillProduceACorrectFullObject(): void
    {
        $agency = new Agency();

        $agency->setActive(true);
        $agency->setCountryId(27);
        $agency->setId(Uuid::uuid4()->toString());
        $agency->setName(Uuid::uuid4()->toString());

        $obj = $agency->jsonSerialize();

        TestCase::assertObjectHasAttribute('id', $obj);
        TestCase::assertObjectHasAttribute('countryId', $obj);
        TestCase::assertObjectHasAttribute('active', $obj);
        TestCase::assertObjectHasAttribute('name', $obj);

        TestCase::assertEquals($agency->getId(), $obj->id);
        TestCase::assertEquals($agency->getCountryId(), $obj->countryId);
        TestCase::assertEquals($agency->isActive(), $obj->active);
        TestCase::assertEquals($agency->getName(), $obj->name);
    }

    public function test_jsonSerializeWillProduceACorrectPartialObject(): void
    {
        $agency = new Agency();

        $agency->setActive(true);
        $agency->setName(Uuid::uuid4()->toString());

        $obj = $agency->jsonSerialize();

        TestCase::assertObjectNotHasAttribute('id', $obj);
        TestCase::assertObjectNotHasAttribute('countryId', $obj);
        TestCase::assertObjectHasAttribute('active', $obj);
        TestCase::assertObjectHasAttribute('name', $obj);

        TestCase::assertEquals($agency->isActive(), $obj->active);
        TestCase::assertEquals($agency->getName(), $obj->name);
    }
}
