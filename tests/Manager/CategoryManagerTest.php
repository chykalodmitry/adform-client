<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Audiens\AdForm\Tests\Manager;

use Audiens\AdForm\Client;
use Audiens\AdForm\Entity\Category;
use Audiens\AdForm\Exception\ApiException;
use Audiens\AdForm\Exception\EntityInvalidException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CategoryManagerTest extends TestCase
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
                echo 'Category delete error: ' .$e->getMessage()."\n";
            }
        }
    }

    private function createFixture(bool $addTearDown = true): Category
    {
        $category = new Category();
        $category->setName(Uuid::uuid4()->toString())
            ->setDataProviderId(SANDBOX_DATA_PROVIDER_ID);
        $category = $this->client->categories()->create($category);

        if ($addTearDown) {
            $this->fixtures[] = $category;
        }

        return $category;
    }

    public function test_getItemWillReturnInstanceOfCategory(): void
    {
        $category = $this->createFixture();

        $category = $this->client->categories()->getItem($category->getId());

        TestCase::assertInstanceOf(Category::class, $category);
    }

    public function test_getItemsWillReturnArrayOfCategories(): void
    {
        $categories = $this->client->categories()->getItems(1);

        TestCase::assertInternalType('array', $categories);

        [$category] = $categories;

        TestCase::assertInstanceOf(Category::class, $category);
    }

    public function test_getItemsDataProviderWillReturnArrayOfCategories(): void
    {
        $categories = $this->client->categories()->getItemsDataProvider(SANDBOX_DATA_PROVIDER_ID, 1);

        TestCase::assertInternalType('array', $categories);

        [$category] = $categories;

        TestCase::assertInstanceOf(Category::class, $category);
    }

    public function test_createWillThrowEntityInvalidException(): void
    {
        $this->expectException(EntityInvalidException::class);

        $category = new Category();
        $this->client->categories()->create($category);
    }

    public function test_updateWillReturnInstanceOfCategory(): void
    {
        $category = $this->createFixture();

        $name = Uuid::uuid4()->toString();
        $category->setName($name);

        $category = $this->client->categories()->update($category);

        TestCase::assertInstanceOf(Category::class, $category);
        TestCase::assertEquals($category->getName(), $name);
    }

    public function test_updateWillThrowEntityInvalidException(): void
    {
        $this->expectException(EntityInvalidException::class);

        $categoryUnique = $this->createFixture();
        $categoryUpdate = $this->createFixture();
        $categoryUpdate->setName($categoryUnique->getName());

        $this->client->categories()->update($categoryUpdate);
    }

    public function test_deleteWillReturnTrue(): void
    {
        $category = $this->createFixture(false);

        $status = $this->client->categories()->delete($category);

        TestCase::assertTrue($status);
    }

    public function test_deleteWillThrowApiException(): void
    {
        $this->expectException(ApiException::class);

        $category = new Category();

        $this->client->categories()->delete($category);
    }
}
