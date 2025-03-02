<?php

declare(strict_types=1);

namespace Koverae\KoveraeBilling\Services\PaymentMethods;

use Koverae\KoveraeBilling\Contracts\PaymentMethodService;
use Koverae\KoveraeBilling\Traits\IsPaymentMethod;

class Free implements PaymentMethodService
{
    use IsPaymentMethod;

    /**
     * Charge desired amount
     * @return void
     */
    public function charge()
    {
        // Nothing is charged, no exception is raised
    }
}
