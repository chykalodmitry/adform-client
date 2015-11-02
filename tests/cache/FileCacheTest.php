<?php

namespace Audiens\AdForm\Tests\Entity;

use Audiens\AdForm\Cache\FileCache;

/**
 * Class CategoryHydratorTest
 */
class FileCacheTest extends \PHPUnit_Framework_TestCase
{
    /** @var FileCache */
    private $fileCache;

    public function setUp()
    {

        $fileCache = new FileCache('.');

        $this->fileCache = $fileCache;
    }

    /**
     * @test
     */
    public function file_cache_will_store_the_data_and_can_be_invalidated()
    {

        $this->fileCache->put('a_prefix','a_uri',['a_query'],'some_data');

        $this->assertEquals('some_data',$this->fileCache->get('a_prefix','a_uri',['a_query']));

        $this->fileCache->invalidate('a_prefix');

        $this->assertFalse($this->fileCache->get('a_prefix','a_uri',['a_query']));

    }

}
