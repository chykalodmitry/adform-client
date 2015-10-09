<?php

namespace DMP\Tests;

use DMP\Adform;
use DMP\Autentication;
use DMP\DataProvider;
use DMP\OauthClient;

/**
 * Class OauthClient
 *
 * @package OauthClient
 */
class OauthClientTest extends \PHPUnit_Framework_TestCase
{

    const SANDBOX_USERNAME = 'francesco.panina';
    const SANDBOX_PASSWORD = 'V9h#Ty8_Qm';

    protected $config = [
        'debug' => true,
        'base_uri' => 'https://dmp-api.adform.com',
        'timeout' => 2.0,
        'headers' => [
            'User-Agent' => 'Audiens',
            'Accept' => 'application/json',
        ],
    ];


    /**
     * @test
     */
    public function autenticate_will_return_an_autentication_object()
    {

        $oauthclient = new OauthClient(self::SANDBOX_USERNAME, self::SANDBOX_PASSWORD, $this->config);

        $adForm = new Adform($oauthclient);

        $dataProviders = $adForm->getDataProviders();

        foreach ($dataProviders as $dataProvider) {
            $this->assertInstanceOf(DataProvider::class, $dataProvider);
        }

    }


}
