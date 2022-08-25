<?php

require "./vendor/autoload.php";

$client_id = '{yourClientId}';
$client_secret = '{yourClientSecret}';
$scopes = [
    "{yourScopes}"
];
$dataProviderId = '{yourDataProviderId}';

// create the API client instance
try {
    $redisConfig = [
        "scheme" => "tcp",
        "host" => "localhost",
        "port" => 6379,
    ];
    $cache = new Audiens\AdForm\Cache\RedisCache($redisConfig);
    $adform = new Audiens\AdForm\Client($client_id, $client_secret, $scopes, $cache);

} catch (Audiens\AdForm\Exception\OauthException $e) {
    exit($e->getMessage());
}

// Get audience grouped by segment
$from = new \DateTime("first day of this month");
$to = new \DateTime("today");
$groupBy = ["segment"];

/** @var stdClass[] */
$dataProviderAudiences = $adform->dataProviderAudience()->get($dataProviderId, $from, $to, $groupBy);

foreach ($dataProviderAudiences as $dataProviderAudience) {
    echo $dataProviderAudience->getDate()->format("d.m.Y.")." - ".$dataProviderAudience->getDataProvider()."\n";
    echo "Total: ".$dataProviderAudience->getTotal()."\n";
    echo "Unique: ".$dataProviderAudience->getUnique()."\n";
    echo "Total Hits: ".$dataProviderAudience->getTotalHits()."\n";
    echo "Unique Hits: ".$dataProviderAudience->getUniqueHits()."\n";

    echo "\n";
}
