<?php declare(strict_types=1);

namespace Audiens\AdForm\Cache;

use Audiens\AdForm\Exception\RedisException;
use Predis\Client;
use Predis\Response\ServerException;

class RedisCache extends BaseCache implements CacheInterface
{
    /** @var Client */
    private $client;

    /** @var int */
    private $ttl;

    /**
     * @param array $config
     * @param int $ttl
     * @param string $prefix
     *
     * @throws RedisException
     */
    public function __construct(array $config, int $ttl = 3600, $prefix = 'adform_')
    {
        parent::__construct($prefix);

        $this->ttl = $ttl;

        try {
            $this->client = new Client($config);
        } catch (ServerException $e) {
            throw RedisException::connect($e->getMessage());
        }
    }

    public function put(string $providerPrefix, string $uri, array $query, string $data): bool
    {
        $hash = $this->getHash($providerPrefix, $uri, $query);

        return (bool) $this->client->set($hash, $data, 'ex', $this->ttl);
    }

    public function get(string $providerPrefix, string $uri, array $query)
    {
        $hash = $this->getHash($providerPrefix, $uri, $query);

        $data = $this->client->get($hash);

        if (!empty($data)) {
            return $data;
        }

        return false;
    }

    public function delete(string $providerPrefix, string $uri, array $query): bool
    {
        $hash = $this->getHash($providerPrefix, $uri, $query);

        return (bool) $this->client->del([$hash]);
    }

    public function invalidate(string $providerPrefix): bool
    {
        $keys = $this->client->keys($this->prefix.strtolower($providerPrefix).'_*');

        foreach ($keys as $key) {
            $this->client->del($key);
        }

        return true;
    }
}
