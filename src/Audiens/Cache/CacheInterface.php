<?php

namespace Audiens\AdForm\Cache;

interface CacheInterface
{
    public function put($uri, $query, $data);

    public function get($uri, $query);

    public function delete($uri, $query);
}
