<?php

use Dotenv\Dotenv;

include __DIR__.'/vendor/autoload.php';

function loadSandboxCredentials()
{
    $dotEnv = new Dotenv(__DIR__);
    $dotEnv->load();

    define('SANDBOX_DATA_PROVIDER_ID', (int)getenv('SANDBOX_DATA_PROVIDER_ID'));
    define('SANDBOX_USERNAME', getenv('SANDBOX_USERNAME'));
    define('SANDBOX_PASSWORD', getenv('SANDBOX_PASSWORD'));
}

loadSandboxCredentials();
