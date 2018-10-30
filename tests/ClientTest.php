<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Audiens\AdForm\Tests;

use Audiens\AdForm\Client;
use Audiens\AdForm\Manager\SegmentManager;
use Audiens\AdForm\Manager\CategoryManager;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private $client;

    public function setUp()
    {
        $this->client = new Client(SANDBOX_USERNAME, SANDBOX_PASSWORD);
    }

    public function test_segmentsWillReturnInstanceOfSegmentsProvider(): void
    {
        TestCase::assertInstanceOf(SegmentManager::class, $this->client->segments());
    }

    public function test_categoriesWillReturnInstanceOfCategoriesProvider(): void
    {
        TestCase::assertInstanceOf(CategoryManager::class, $this->client->categories());
    }
}
