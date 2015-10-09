<?php

namespace DMP;

use MyCLabs\Enum\Enum;

/**
 * @method static DataProviderType DATA_PROVIDER()
 * @method static DataProviderType PUBLISHER()
 */
class DataProviderType extends Enum
{

    const __default = self::DATA_PROVIDER;

    const DATA_PROVIDER = 'dataProvider';
    const PUBLISHER     = 'publisher';

}


