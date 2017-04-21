<?php

namespace Audiens\AdForm\Tests\Entity;

/**
 * Class AgencyHydratorTest
 */
class AgencyHydratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function hydratorWillReturnCategoryObject()
    {
        $stdClass = new \stdClass();
        $stdClass->id = 10;
        $stdClass->name = 'testAgency';
        $stdClass->active = true;
        $stdClass->countryId = 50;

        $agency = \Audiens\AdForm\Entity\AgencyHydrator::fromStdClass($stdClass);

        $this->assertInstanceOf(\Audiens\AdForm\Entity\Agency::class, $agency);
    }
}
