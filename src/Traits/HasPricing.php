<?php


namespace Koverae\KoveraeBilling\Traits;


trait HasPricing
{
    /**
     * Check if is free.
     *
     * @return bool
     */
    public function isFree(): bool
    {
        return (float)$this->price <= 0.00;
    }
}
