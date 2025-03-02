<?php

namespace Koverae\KoveraeBilling\Traits;

trait MorphsSchedules
{
    /**
     * Get all schedules.
     */
    public function schedules()
    {
        return $this->morphMany(config('koverae-billing.models.plan_subscription_schedule'), 'scheduleable');
    }
    
}
