<?php

namespace Audiens\AdForm\Cache;

/**
 * Class BaseCache
 */
class BaseCache
{
    /**
     * @var string
     */
    protected $prefix;

    /**
     * @param string $providerPrefix
     * @param string $uri
     * @param string $query
     *
     * @return string
     */
    protected function getHash($providerPrefix, $uri, $query)
    {
        return $this->prefix.strtolower($providerPrefix).'_'.md5($uri.'?'.http_build_query($query));
    }
}
