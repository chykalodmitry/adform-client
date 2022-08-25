# adform-client

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

A PHP client library for [AdForm's API (DMP)](https://api.adform.com/v1/help/dmp).

# Available endpoints

The current implementation covers the following endpoints:
* [Segments](https://api.adform.com/v1/help/dmp#/Segment)
* [Categories](https://api.adform.com/v1/help/dmp#/Category)
* [Data usage report](https://api.adform.com/v1/help/dmp#/Report)
* [Data Provider Audience report](https://api.adform.com/v1/help/dmp#/Report)
* [Agencies](https://api.adform.com/v1/help/dmp#/Agency)

# Usage

```php
require 'vendor/autoload.php';

$client_id = '{yourClientId}';
$client_secret = '{yourClientSecret}';
$scopes = [
    "{yourScopes}"
];

try {
    $adform = new Audiens\AdForm\Client($client_id, $client_secret, $scopes);
} catch (Audiens\AdForm\Exception\OauthException $e) {
    exit("Auth failed with message: ".$e->getMessage());
}

// Get 10 categories
$categories = $adform->categories()->getItems(10);
foreach ($categories as $category) {
    echo $category->getName()."\n";
}

// create a new category
$category = new Audiens\AdForm\Entity\Category();
$category->setName('Test')
    ->setDataProviderId(10000);

$category = $adform->categories()->create($category);
```

More examples are available in the examples dir.

# Cache

The package has an optional ability to cache the API call locally. Two cache drivers are available, Redis and File.

```php
require 'vendor/autoload.php';

$client_id = '{yourClientId}';
$client_secret = '{yourClientSecret}';
$scopes = [
    "{yourScopes}"
];

// Redis driver
try {
    $redisConfig = [
        'scheme' => 'tcp',
        'host' => '192.168.10.10',
        'port' => 6379,
    ];
    $cacheRedis = new Audiens\AdForm\Cache\RedisCache($redisConfig);
    $adformRedis = new Audiens\AdForm\Client($client_id, $client_secret, $scopes, $cacheRedis);
} catch (Audiens\AdForm\Exception\OauthException $e) {
    exit("Auth failed with message: ".$e->getMessage());
}

// File driver
try {
    $path = '/path/to/your/cache/dir'
    $cacheFile = new Audiens\AdForm\Cache\FileCache($path);
    $adformFile = new Audiens\AdForm\Client($username, $password, $cache);
} catch (Audiens\AdForm\Exception\OauthException $e) {
    exit("Auth failed with message: ".$e->getMessage());
}
```

# License

The MIT License (MIT). Please see LICENSE for more information.
