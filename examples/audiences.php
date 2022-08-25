<?php

require './vendor/autoload.php';

$client_id = '{yourClientId}';
$client_secret = '{yourClientSecret}';
$scopes = [
    "{yourScopes}"
];
// create the API client instance
try {
    $redisConfig = [
        'scheme' => 'tcp',
        'host' => 'localhost',
        'port' => 6379,
    ];
    $cache = new Audiens\AdForm\Cache\RedisCache($redisConfig);
    $adform = new Audiens\AdForm\Client($client_id, $client_secret, $scopes, $cache);
} catch (Audiens\AdForm\Exception\OauthException $e) {
    exit($e->getMessage());
}

//audiences by segment id
/** @var \Audiens\AdForm\Entity\Audience[] $audiences */
$audiences = $adform->audience()->getItem(12345);
foreach($audiences as $audience)
{
    echo $audience->getSegmentId()."\n";
    echo $audience->getDate()->format('yyyy-mm-dd')."\n";
    echo $audience->getTotal()."\n";
}