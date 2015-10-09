<?php

namespace DMP;

use MyCLabs\Enum\Enum;

/**
 * @method static Pricing MAX()
 * @method static Pricing SUM()
 */
class Pricing extends Enum
{

    const __default = self::MAX;

    const MAX = 'max';
    const SUM = 'sum';
}
