<?php

namespace Koverae\KoveraeBilling\Controllers\Payments;

use App\Http\Controllers\Controller;
use Koverae\KoveraeBilling\Services\PaymentMethods\Paystack;
use Illuminate\Http\Request;

class PaystackController extends Controller
{

    protected $paystackService;

    public function __construct(Paystack $paystackService)
    {
        $this->paystackService = $paystackService;
    }

    public function initiate(Request $request)
    {
        $this->paystackService->initializePayment(
            $request->name,
            $request->email,
            $request->amount,
            $request->plan->plan_code,
            $request->invoicePeriod,
            $request->billingCycle
        );
    }

    public function callback(Request $request)
    {
        return $this->paystackService->handleCallback($request);
    }

    public function handle(Request $request)
    {
        return $this->paystackService->handle($request);
    }

}
