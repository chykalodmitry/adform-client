<?php

namespace Audiens\AdForm\Cache;

/**
 * Interface CacheInterface
 */
interface CacheInterface
{
    /**
     * @param $uri
     * @param $query
     * @param $data
     *
     * @return void
     */
    public function put($uri, $query, $data);

    /**
     * @param $uri
     * @param $query
     *
     * @return bool
     */
    public function get($uri, $query);

    /**
     * @param $uri
     * @param $query
     *
     * @return bool
     */
    public function delete($uri, $query);
}
