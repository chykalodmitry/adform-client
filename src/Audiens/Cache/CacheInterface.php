<?php

namespace Audiens\AdForm\Cache;

/**
 * Interface CacheInterface
 */
interface CacheInterface
{
    /**
     * @param $providerPrefix
     * @param $uri
     * @param $query
     * @param $data
     *
     * @return bool
     */
    public function put($providerPrefix, $uri, $query, $data);

    /**
     * @param $providerPrefix
     * @param $uri
     * @param $query
     *
     * @return bool|mixed
     */
    public function get($providerPrefix, $uri, $query);

    /**
     * @param $providerPrefix
     * @param $uri
     * @param $query
     *
     * @return bool
     */
    public function delete($providerPrefix, $uri, $query);

    /**
     * @param $providerPrefix
     *
     * @return bool
     */
    public function invalidate($providerPrefix);
}
