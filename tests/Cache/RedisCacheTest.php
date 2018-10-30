<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Predis;

use PHPUnit\Framework\TestCase;

/**
 * Required as the current implementation instantiates a Predis\Client directly,
 * instead of passing it as a dependency.
 *
 * @method mixed  set($key, $value, $expireResolution = null, $expireTTL = null, $flag = null)
 * @method string get($key)
 * @method array  keys($pattern)
 */
class Client {
    /** @var array */
    private $asserts;

    public function __construct(array $configuration) {
        $this->asserts = $configuration;
    }

    public function __call(string $method, array $args)
    {
        $assert = $this->asserts[$method] ?? null;

        TestCase::assertNotNull($assert, "If it's called, it should have tests");

        return \call_user_func_array($assert, $args);
    }
}

namespace Audiens\AdForm\Tests\Cache;

use Audiens\AdForm\Cache\RedisCache;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class RedisCacheTest extends TestCase
{
    public function test_putWillSaveTheData(): void
    {
        $ttl = 5;
        $prefix = 'MyPrefix_';

        $providerPrefix = Uuid::uuid4()->toString();
        $uri = Uuid::uuid4()->toString();
        $query = [Uuid::uuid4()->toString()];
        $data = Uuid::uuid4()->toString();

        $expectedKey = $prefix.$providerPrefix.'_'.md5($uri.'?'.http_build_query($query));

        $config = [
            'set' => function ($key, $value, $expireResolution, $expireTTL) use ($expectedKey, $data, $ttl) {
                TestCase::assertEquals($expectedKey, $key);
                TestCase::assertEquals($data, $value);
                TestCase::assertEquals('ex', $expireResolution);
                TestCase::assertEquals($ttl, $expireTTL);
            }
        ];

        $cache = new RedisCache($config, $ttl, $prefix);
        $cache->put($providerPrefix, $uri, $query, $data);
    }

    public function test_getWillAskForCorrectKey(): void
    {
        $ttl = 5;
        $prefix = 'MyPrefix_';
        $providerPrefix = Uuid::uuid4()->toString();
        $uri = Uuid::uuid4()->toString();
        $query = [Uuid::uuid4()->toString()];

        $expectedKey = $prefix.$providerPrefix.'_'.md5($uri.'?'.http_build_query($query));

        $config = [
            'get' => function (string $key) use ($expectedKey) {
                TestCase::assertEquals($expectedKey, $key);

                return '';
            }
        ];

        $cache = new RedisCache($config, $ttl, $prefix);
        $cache->get($providerPrefix, $uri, $query);
    }

    public function test_deleteWillRequestTheKeyDeletion(): void
    {
        $ttl = 5;
        $prefix = 'MyPrefix_';
        $providerPrefix = Uuid::uuid4()->toString();
        $uri = Uuid::uuid4()->toString();
        $query = [Uuid::uuid4()->toString()];

        $expectedKey = $prefix.$providerPrefix.'_'.md5($uri.'?'.http_build_query($query));

        $config = [
            'del' => function (array $keys) use ($expectedKey) {
                TestCase::assertCount(1, $keys);
                TestCase::assertEquals($expectedKey, $keys[0]);

                return '';
            }
        ];

        $cache = new RedisCache($config, $ttl, $prefix);
        $cache->delete($providerPrefix, $uri, $query);
    }

    public function test_invalidateWillInvalidateAllThePrefixedKeys(): void
    {
        $prefix = 'MyPrefix_';
        $providerPrefix = Uuid::uuid4()->toString();
        $ttl = 5;
        $keys = [];
        for ($i = 0; $i < 10; $i++) {
            $keys[] = $prefix . Uuid::uuid4()->toString();
        }

        $expectedProviderPrefix = $prefix.$providerPrefix.'_*';

        $config = [
            'keys' => function ($givenPrefix) use ($expectedProviderPrefix, $keys) {
                TestCase::assertEquals($expectedProviderPrefix, $givenPrefix);

                return \array_values($keys);
            },

            'del' => function (array $givenKeys) use ($keys) {
                TestCase::assertNotCount(0, $givenKeys);
                foreach ($givenKeys as $key) {
                    TestCase::assertNotFalse(\array_search($key, $keys, true));
                }
            }
        ];

        $cache = new RedisCache($config, $ttl, $prefix);
        $cache->invalidate($providerPrefix);
    }
}
