<?php

namespace Audiens\AdForm\Cache;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

class FileCache extends BaseCache implements CacheInterface
{
    /**
     * @var Flysystem
     */
    private $filesystem;

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
     */
    public function __construct($path, $ttl = 3600, $prefix = "adform_")
    {
        $adapter = new Local($path);
        $this->filesystem = new Filesystem($adapter);

        $this->ttl = $ttl;

        $this->prefix = $prefix;
    }

    /**
     * @param string $uri
     * @param string $query
     * @param string $data
     */
    public function put($uri, $query, $data)
    {
        $hash = $this->getHash($uri, $query);

        $this->filesystem->put($hash, json_encode($data));
    }

    /**
     * @param string $uri
     * @param string $query
     */
    public function get($uri, $query)
    {
        $hash = $this->getHash($uri, $query);
        $ttlCutoff = time() - $this->ttl;

        if ($this->filesystem->has($hash) and $this->filesystem->getTimestamp($hash) > $ttlCutoff) {
            $data = json_decode($this->filesystem->read($hash));

            if (!empty($data)) {
                return $data;
            }
        }

        return false;
    }

    /**
     * @param string $uri
     * @param string $query
     */
    public function delete($uri, $query)
    {
        $hash = $this->getHash($uri, $query);

        $this->filesystem->delete($hash);
    }
}
