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
        exit("AdForm Auth failed with message: ".$e->getMessage());
    }

    // Get 10 segments
    $segments = $adform->segments()->getItems(2);
    foreach ($segments as $segment) {
        echo $segments->getName()."\n";
    }

    // Get 10 segments for your data provider
    $segments = $adform->segments()->getItemsDataProvider($dataProviderId, 10);
    foreach ($segments as $segments) {
        echo $segments->getName()."\n";
    }

    // Get 10 segments from a category
    $categoryId = '{categoryId}';
    $segments = $adform->segments()->getItemsDataProvider($categoryId, 10);
    foreach ($segments as $segments) {
        echo $segments->getName()."\n";
    }

    try {
        // Create a segments
        $segment = new Audiens\AdForm\Entity\Segment();
        $segment->setName('Test1234')
            ->setDataProviderId($dataProviderId)
            ->setStatus('active')
            ->setTtl(100)
            ->setCategoryId($categoryId)
            ->setFrequency(5)
            ->setRefId('test1234')
            ->setFee(0.6);
        $segment = $adform->segments()->create($segment);

        // Reload the segment from the API
        $segment = $adform->segments()->getItem($segment->getId());
        echo $segment->getName()."\n";

        // Update the name
        $segment->setName($segment->getName().'1');
        $segment = $adform->segments()->update($segment);
        echo $segment->getName()."\n";

        // Delete the segment
        $status = $adform->segments()->delete($segment);

    } catch (Audiens\AdForm\Exception\EntityInvalidException $e) { // API returned a validation error
        echo "Validation error: ".$e->getCode()." ".$e->getMessage()."\n";

        $validationErrors = $e->getErrors();
        foreach ($validationErrors as $validationError) {
            echo $validationError."\n";
        }
    } catch (Audiens\AdForm\Exception\ApiException $e) { //  API returned a general error
        echo "Api error: ".$e->getCode()." ".$e->getMessage()."\n";
    }
