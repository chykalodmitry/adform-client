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

    // Get 10 categories
    $categories = $adform->categories()->getItems(10);
    foreach ($categories as $category) {
        echo $category->getName()."\n";
    }

    // Get 10 categories for your data provider
    $categories = $adform->categories()->getItemsDataProvider($dataProviderId, 10);
    foreach ($categories as $category) {
        echo $category->getName()."\n";
    }

    try {
        // Create a category
        $category = new Audiens\AdForm\Entity\Category();
        $category->setName('Test')
            ->setDataProviderId($dataProviderId);
        $category = $adform->categories()->create($category);

        // Reload the category from the API
        $category = $adform->categories()->getItem($category->getId());
        echo $category->getName()."\n";

        // Update the name
        $category->setName($category->getName().'1');
        $category = $adform->categories()->update($category);
        echo $category->getName()."\n";

        // Delete the category
        $status = $adform->categories()->delete($category);

    } catch (Audiens\AdForm\Exception\EntityInvalidException $e) { // API returned a validation error
        echo "Validation error: ".$e->getCode()." ".$e->getMessage()."\n";

        $validationErrors = $e->getErrors();
        forach ($validationErrors as $validationError) {
            echo $validationError."\n";
        }
    } catch (Audiens\AdForm\Exception\ApiException $e) { //  API returned a general error
        echo "Api error: ".$e->getCode()." ".$e->getMessage()."\n";
    }
