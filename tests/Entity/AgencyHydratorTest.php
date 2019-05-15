<?php 

namespace Tests\Entity;

use Audiens\AdForm\Entity\Agency;
use Audiens\AdForm\Entity\AgencyHydrator;
use PHPUnit\Framework\TestCase;
use stdClass;

class AgencyHydratorTest extends TestCase
{
    public function test_hydratorWillReturnCategoryObject(): void
    {
        $stdClass = new stdClass();
        $stdClass->id = 10;
        $stdClass->name = 'testAgency';
        $stdClass->active = true;
        $stdClass->countryId = 50;

        $agency = AgencyHydrator::fromStdClass($stdClass);

        TestCase::assertInstanceOf(Agency::class, $agency);
    }
}
