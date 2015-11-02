<?php

namespace Audiens\AdForm\Cache;

use Audiens\AdForm\Exception\RedisException;
use Predis\Client;
use Predis\Response\ServerException;

/**
 * Class RedisCache
 */
class RedisCache extends BaseCache implements CacheInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var int
     */
    private $ttl;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @param array $config
     * @param int $ttl
     * @param string $prefix
     *
     * @throws RedisException
     */
    public function __construct($config, $ttl = 3600, $prefix = "adform_")
    {
        try {
            $this->client = new Client($config);
        } catch (ServerException $e) {
            throw RedisException::connect($e->getMessage());
        }

        $this->ttl = $ttl;

        $this->prefix = $prefix;
    }

    /**
     * @param string $providerPrefix
     * @param string $uri
     * @param string $query
     * @param string $data
     *
     * @return bool
     */
    public function put($providerPrefix, $uri, $query, $data)
    {
        $hash = $this->getHash($providerPrefix, $uri, $query);

        return (bool) $this->client->set($hash, $data, "ex", $this->ttl);
    }

    /**
     * @param string $providerPrefix
     * @param string $uri
     * @param string $query
     *
     * @return bool|mixed
     */
    public function get($providerPrefix, $uri, $query)
    {
        $hash = $this->getHash($providerPrefix, $uri, $query);

        $data = $this->client->get($hash);

        if (!empty($data)) {
            return $data;
        }

        return false;
    }

    /**
     * @param string $providerPrefix
     * @param string $uri
     * @param string $query
     *
     * @return bool
     */
    public function delete($providerPrefix, $uri, $query)
    {
        $hash = $this->getHash($providerPrefix, $uri, $query);

        return (bool) $this->client->del($hash);
    }

    /**
     * @param string $providerPrefix
     *
     * @return bool
     */
    public function invalidate($providerPrefix)
    {
        $keys = $this->client->keys($this->prefix.strtolower($providerPrefix).'_*');

        foreach ($keys as $key) {
            $this->client->del($key);
        }

        return true;
    }
}
