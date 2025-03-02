<?php

namespace Koverae\KoveraeBilling;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Koverae\KoveraeBilling\Skeleton\SkeletonClass
 */
class KoveraeBillingFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'koverae-billing';
    }
}
