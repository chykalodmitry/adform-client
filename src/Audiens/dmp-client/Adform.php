<?php

namespace DMP;

/**
 * Class Adform
 *
 * @package Adform
 */
class Adform
{
    /**
     * @const string Version number of the Adform PHP SDK.
     */
    const VERSION = '0.0.0';

    /** @var */
    protected $oauthClient;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {

    }

    /**
     * @param $currencyCodes array Collection of string
     * @param $search        string
     * @param $filter        string
     * @param $sort
     * @param $offset        int
     * @param $limit         int
     *
     * Returns list of available providers Use "ActiveCountryIds eq global" for filtering of globally
     * active DataProviders, or "ActiveCountryIds eq [10, 17, 53] for filtering of DataProviders,
     * active just in specified countries"
     *
     */
    public function getDataProviders($filter, $sort, $currencyCodes = null, $search = null, $offset, $limit)
    {

    }


}
