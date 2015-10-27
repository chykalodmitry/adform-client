<?php

namespace Audiens\AdForm\Cache;

/**
 * Class BaseCache
 */
class BaseCache
{
    /** @var  string */
    protected $prefix;

    /**
     * @param string $uri
     * @param string $query
     *
     * @return string
     */
    protected function getHash($uri, $query)
    {
        return $this->prefix.md5($uri.'?'.http_build_query($query));
    }
}
