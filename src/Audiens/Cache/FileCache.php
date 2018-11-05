<?php declare(strict_types=1);

namespace Audiens\AdForm\Cache;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

class FileCache extends BaseCache implements CacheInterface
{
    /** @var Filesystem */
    private $filesystem;

    /** @var int */
    private $ttl;

    public function __construct(string $path, int $ttl = 3600)
    {
        parent::__construct($path);

        if (!\in_array($path[0], ['.', '/'])) {
            $path = sys_get_temp_dir().DIRECTORY_SEPARATOR.$path;
        }

        $adapter = new Local($path);
        $this->filesystem = new Filesystem($adapter);

        $this->ttl = $ttl;
    }

    public function getFilesystem(): Filesystem
    {
        return $this->filesystem;
    }

    public function put(string $providerPrefix, string $uri, array $query, string $data): bool
    {
        $hash = $this->getHash($providerPrefix, $uri, $query);

        return $this->filesystem->put($hash, $data);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function get(string $providerPrefix, string $uri, array $query)
    {
        $hash = $this->getHash($providerPrefix, $uri, $query);
        $ttlCutoff = time() - $this->ttl;

        if ($this->filesystem->has($hash) && $this->filesystem->getTimestamp($hash) > $ttlCutoff) {
            $data = $this->filesystem->read($hash);

            if (!empty($data)) {
                return $data;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function delete(string $providerPrefix, string $uri, array $query): bool
    {
        $hash = $this->getHash($providerPrefix, $uri, $query);

        if ($this->filesystem->has($hash)) {
            return $this->filesystem->delete($hash);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function invalidate(string $providerPrefix): bool
    {
        $pattern = $this->prefix.strtolower($providerPrefix).'_';

        $files = $this->filesystem->listContents();
        foreach ($files as $file) {
            if (stripos($file['basename'], $pattern) === 0) {
                $this->filesystem->delete($file['basename']);
            }
        }

        return true;
    }
}
