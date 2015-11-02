<?php

namespace Audiens\AdForm\Tests\Entity;

/**
 * Class CategoryHydratorTest
 */
class CategoryHydratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function hydratorWillReturnCategoryObject()
    {
        $stdClass = new \stdClass();
        $stdClass->id = 10;
        $stdClass->name = 'TestCategory';
        $stdClass->dataProviderId = 10000;
        $stdClass->parentId = 20000;
        $stdClass->createdAt = '2015-10-10';
        $stdClass->updatedAt = '2015-10-10';

        $category = \Audiens\AdForm\Entity\CategoryHydrator::fromStdClass($stdClass);

        $this->assertInstanceOf(\Audiens\AdForm\Entity\Category::class, $category);
    }
}
