# adform-client

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://travis-ci.org/Audiens/adform-client.svg?branch=master)](https://travis-ci.org/Audiens/adform-client)
[![Coverage Status](https://coveralls.io/repos/github/Audiens/adform-client/badge.svg?branch=master)](https://coveralls.io/github/Audiens/adform-client?branch=master)
[![Maintainability](https://api.codeclimate.com/v1/badges/9be5218a12a58763c8aa/maintainability)](https://codeclimate.com/github/Audiens/adform-client/maintainability)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Audiens/adform-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Audiens/adform-client/?branch=master)


A PHP client library for [AdForm's DMP API](https://dmp.adform.com/help/).

# Installation Using [Composer](http://getcomposer.org/)

```bash
$ composer require Audiens/adform-client
```

# Available endpoints

The current implementation covers the following endpoints:
* [Segments](https://dmp.adform.com/Help#data_provider_segments_service)
* [Categories](https://dmp.adform.com/Help#data_provider_categories_service)
* [Data usage report](https://dmp.adform.com/Help#reports_service)
* [Data Provider Audience report](https://dmp.adform.com/Help#reports_service)
* [Agencies](https://dmp.adform.com/Help#agency_service)

# Usage

```php
require 'vendor/autoload.php';

$username = '{yourUsername}';
$password = '{yourPassword}';

try {
    $adform = new Audiens\AdForm\Client($username, $password);
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

$username = '{yourUsername}';
$password = '{yourPassword}';

// Redis driver
try {
    $redisConfig = [
        'scheme' => 'tcp',
        'host' => '192.168.10.10',
        'port' => 6379,
    ];
    $cacheRedis = new Audiens\AdForm\Cache\RedisCache($redisConfig);
    $adformRedis = new Audiens\AdForm\Client($username, $password, $cacheRedis);
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
