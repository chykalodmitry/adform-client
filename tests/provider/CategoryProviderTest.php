<?php

namespace Audiens\AdForm\Tests\Provider;

use Audiens\AdForm\Client;
use Audiens\AdForm\Entity\Category;

/**
 * Class CategoryProviderTest
 */
class CategoryProviderTest extends \PHPUnit_Framework_TestCase
{
    /** @var Client */
    private $client;

    private $fixtures = [];

    public function setUp()
    {
        $this->client = new Client(SANDBOX_USERNAME, SANDBOX_PASSWORD);
    }

    public function tearDown()
    {
        foreach ($this->fixtures as $fixture) {
            try {
                $this->client->categories()->delete($fixture);
            } catch (\Exception $e) {
                echo "Category delete error: ".$e->getMessage()."\n";
            }
        }
    }

    private function getRandomName()
    {
        return 'Test'.substr(uniqid('', true), 0, 10);
    }

    private function createFixture($addTearDown = true, $forceCreate = false)
    {
        $category = new Category();
        $category->setName($this->getRandomName())
            ->setDataProviderId(SANDBOX_DATA_PROVIDER_ID);
        $category = $this->client->categories()->create($category);

        if ($addTearDown) {
            $this->fixtures[] = $category;
        }

        return $category;
    }

    /**
     * @test
     */
    public function geItemWillReturnInstanceOfCategory()
    {
        $category = $this->createFixture();

        $category = $this->client->categories()->getItem($category->getId());

        $this->assertInstanceOf(Category::class, $category);
    }

    /**
     * @test
     */
    public function geItemsWillReturnArrayOfCategories()
    {
        $categories = $this->client->categories()->getItems(1);

        $this->assertInternalType('array', $categories);

        list($category) = $categories;

        $this->assertInstanceOf(Category::class, $category);
    }

    /**
     * @test
     */
    public function getItemsDataProviderWillReturnArrayOfCategories()
    {
        $categories = $this->client->categories()->getItemsDataProvider(SANDBOX_DATA_PROVIDER_ID, 1);

        $this->assertInternalType('array', $categories);

        list($category) = $categories;

        $this->assertInstanceOf(Category::class, $category);
    }

    /**
     * @test
     */
    public function createWillReturnInstanceOfCategory()
    {
        $category = $this->createFixture();

        $this->assertInstanceOf(Category::class, $category);
    }

    /**
     * @test
     */
    public function createWillThrowEntityInvalidException()
    {
        $this->setExpectedException('Audiens\AdForm\Exception\EntityInvalidException');

        $category = new Category();
        $category = $this->client->categories()->create($category);
    }

    /**
     * @test
     */
    public function updateWillReturnInstanceOfCategory()
    {
        $category = $this->createFixture();

        $name = $this->getRandomName();
        $category->setName($name);

        $category = $this->client->categories()->update($category);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals($category->getName(), $name);
    }

    /**
     * @test
     */
    public function updateWillThrowEntityInvalidException()
    {
        $this->setExpectedException('Audiens\AdForm\Exception\EntityInvalidException');

        $categoryUnique = $this->createFixture();
        $categoryUpdate = $this->createFixture();
        $categoryUpdate->setName($categoryUnique->getName());

        $this->client->categories()->update($categoryUpdate);
    }

    /**
     * @test
     */
    public function deleteWillReturnTrue()
    {
        $category = $this->createFixture(false);

        $status = $this->client->categories()->delete($category);

        $this->assertTrue($status);
    }

    /**
     * @test
     */
    public function deleteWillThrowApiException()
    {
        $this->setExpectedException('Audiens\AdForm\Exception\ApiException');

        $category = new Category();

        $this->client->categories()->delete($category);
    }
}
