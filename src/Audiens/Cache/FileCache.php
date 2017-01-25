<?php

namespace Audiens\AdForm\Cache;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

/**
 * Class FileCache
 */
class FileCache extends BaseCache implements CacheInterface
{
    /**
     * @var Filesystem
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
     * @param string $path
     * @param int $ttl
     * @param string $prefix
     */
    public function __construct($path, $ttl = 3600, $prefix = "adform_")
    {
        $adapter = new Local($path);
        $this->filesystem = new Filesystem($adapter);

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

        return $this->filesystem->put($hash, $data);
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
        $ttlCutoff = time() - $this->ttl;

        if ($this->filesystem->has($hash) and $this->filesystem->getTimestamp($hash) > $ttlCutoff) {
            $data = $this->filesystem->read($hash);

            if (!empty($data)) {
                return $data;
            }
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

        if ($this->filesystem->has($hash)) {
            return $this->filesystem->delete($hash);
        }

        return false;
    }

    /**
     * @param string $providerPrefix
     *
     * @return bool
     */
    public function invalidate($providerPrefix)
    {
        $pattern = $this->prefix.strtolower($providerPrefix).'_';

        $files = $this->filesystem->listContents();
        foreach ($files as $file) {
            if (stripos($file['filename'], $pattern) === 0) {
                $this->filesystem->delete($file['filename']);
            }
        }

        return true;
    }
}
