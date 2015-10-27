<?php

namespace Audiens\AdForm\Cache;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

class BaseCache
{
    /**
     * @param string $uri
     * @param string $query
     */
    protected function getHash($uri, $query)
    {
        return $this->prefix.md5($uri.'?'.http_build_query($query));
    }
}
