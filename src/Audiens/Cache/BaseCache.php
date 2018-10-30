<?php declare(strict_types=1);

namespace Audiens\AdForm\Cache;

class BaseCache
{
    /** @var string */
    protected $prefix;

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    protected function getHash(string $providerPrefix, string $uri, array $query): string
    {
        return $this->prefix.strtolower($providerPrefix).'_'.md5($uri.'?'.http_build_query($query));
    }
}
