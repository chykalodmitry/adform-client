<?php

namespace Audiens\AdForm\Tests;

use Audiens\AdForm\Client;
use Audiens\AdForm\Provider\SegmentProvider;
use Audiens\AdForm\Provider\CategoryProvider;

/**
 * Class ClientTest
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    private $client;

    public function setUp()
    {
        $this->client = new Client(SANDBOX_USERNAME, SANDBOX_PASSWORD);
    }

    /**
     * @test
     */
    public function segmentsWillReturnInstanceOfSegmentsProvider()
    {
        $this->assertInstanceOf(SegmentProvider::class, $this->client->segments());
    }

    /**
     * @test
     */
    public function categoriesWillReturnInstanceOfCategoriesProvider()
    {
        $this->assertInstanceOf(CategoryProvider::class, $this->client->categories());
    }
}
