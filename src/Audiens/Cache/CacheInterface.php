<?php declare(strict_types=1);

namespace Audiens\AdForm\Cache;

interface CacheInterface
{
    public function put(string $providerPrefix, string $uri, array $query, string $data): bool;

    /**
     * @param string $providerPrefix
     * @param string $uri
     * @param array  $query
     *
     * @return bool|mixed
     */
    public function get(string $providerPrefix, string $uri, array $query);

    public function delete(string $providerPrefix, string $uri, array $query): bool;

    public function invalidate(string $providerPrefix): bool;
}
