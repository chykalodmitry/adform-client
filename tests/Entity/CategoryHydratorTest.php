<?php 

namespace Tests\Entity;

use Audiens\AdForm\Entity\Category;
use Audiens\AdForm\Entity\CategoryHydrator;
use PHPUnit\Framework\TestCase;

class CategoryHydratorTest extends TestCase
{
    public function test_hydratorWillReturnCategoryObject(): void
    {
        $stdClass = new \stdClass();
        $stdClass->id = 10;
        $stdClass->name = 'TestCategory';
        $stdClass->dataProviderId = 10000;
        $stdClass->parentId = 20000;
        $stdClass->createdAt = '2015-10-10';
        $stdClass->updatedAt = '2015-10-10';

        $category = CategoryHydrator::fromStdClass($stdClass);
        TestCase::assertInstanceOf(Category::class, $category);
    }
}
