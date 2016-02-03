<?php

require '../vendor/autoload.php';

$username = '{yourUsername}';
$password = '{yourPassword}';
$dataProviderId = '{yourDataProviderId}';

// create the API client instance
try {
    $redisConfig = [
        'scheme' => 'tcp',
        'host' => 'localhost',
        'port' => 6379,
    ];
    $cache = new Audiens\AdForm\Cache\RedisCache($redisConfig);
    $adform = new Audiens\AdForm\Client($username, $password, $cache);

} catch (Audiens\AdForm\Exception\OauthException $e) {
    exit($e->getMessage());
}

// Get data usage grouped by segment
$from = new DateTime('first day of this month');
$to = new DateTime('today');
$groupBy = ['segment'];
/** @var stdClass[] */
$dataUsage = $adform->dataUsage()->get($dataProviderId, $from, $to, $groupBy);
foreach ($dataUsage as $usage) {
    echo $usage->segmentsGroup.": ".$usage->revenue."\n";
}
