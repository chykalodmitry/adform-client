<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Audiens\AdForm\Tests\Cache;

use Audiens\AdForm\Cache\FileCache;
use League\Flysystem\Adapter\Local;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class FileCacheTest extends TestCase
{
    /** @var FileCache */
    private $fileCache;

    public function setUp(): void
    {
        $this->fileCache = new FileCache('fandom');
    }

    public function tearDown(): void
    {
        /** @var Local $adapter */
        $adapter = $this->fileCache->getFilesystem()->getAdapter();
        $root = $adapter->getPathPrefix();
        \rmdir($root);
    }

    public function test_fileCacheWillStoreTheDataAndCanBeInvalidated(): void
    {
        $prefix = 'a_prefix';
        $uri = 'a_uri';
        $query = ['a_query'];
        $content = 'some_data';

        $this->fileCache->put($prefix, $uri, $query, $content);
        TestCase::assertEquals($content, $this->fileCache->get($prefix, $uri, $query));

        $this->fileCache->invalidate('a_prefix');
        TestCase::assertFalse($this->fileCache->get('a_prefix','a_uri', ['a_query']));
    }
}
