<?php

namespace DMP;

/**
 * Class DataProviderStatus
 */
class DataProviderStatus extends \SplEnum
{

    const __default = self::ACTIVE;

    const ACTIVE   = 'Active';
    const INACTIVE = 'Inactive';
    const PENDING = 'Pending';

}


