<?php

namespace DMP;

use MyCLabs\Enum\Enum;

/**
 * @method static DataProviderStatus ACTIVE()
 * @method static DataProviderStatus INACTIVE()
 * @method static DataProviderStatus PENDING()
 */
class DataProviderStatus extends Enum
{

    const __default = self::ACTIVE;

    const ACTIVE   = 'active';
    const INACTIVE = 'inactive';
    const PENDING = 'pending';

}


