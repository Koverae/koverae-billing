<?php

declare(strict_types=1);

namespace Koverae\KoveraeBilling\Services\PaymentMethods;

use App\Models\Team\Team;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Koverae\KoveraeBilling\Contracts\PaymentMethodService;
use Koverae\KoveraeBilling\Traits\IsPaymentMethod;
use Koverae\KoveraeBilling\Models\PlanSubscription;
use Koverae\KoveraeBilling\Models\Transaction;

class Paystack implements PaymentMethodService
{
    use IsPaymentMethod;

    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->secretKey = config('koverae-billing.paystack.secret_key'); // Store in .env
        $this->baseUrl = config('koverae-billing.paystack.base_url');
    }

    /**
     * Charge desired amount
     * @return void
     */
    public function charge()
    {
        // Nothing is charged, no exception is raised
    }


    /**
    * Initialize a payment with Paystack.
    *
    * @param string $email The customer's email address.
    * @param float $amount The payment amount (in major currency units, e.g., KES).
    * @param string|null $plan Optional plan code for subscriptions.
    * @return \Illuminate\Http\RedirectResponse Redirects to Paystack's payment page.
    */
    public function initializePayment($name = null, $email, $amount, $plan = null, $period = 1, $interval = 'month')
    {
        $amount = $amount * 100; // Paystack processes payments in kobo (cents), so multiply by 100.
        $client = new Client();

        $response = $client->post($this->baseUrl  . '/transaction/initialize', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'name' => $name,
                'email' => $email,
                'amount' => $amount,
                'plan' => $plan,
                'callback_url' => route('paystack.callback'),// Redirect after payment
                'metadata' => [
                    'team_id' => current_company()->team->id, // Attach team ID for reference
                    'invoice_period' => $period,
                    'invoice_interval' => $interval,
                    // 'subscription_id' => $subscription->id,
                ]
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true); // Use true for an associative array

        // Redirect to Paystack payment page if the initialization was successful
        if ($result['status']) {
            return redirect($result['data']['authorization_url']);
        }

        // Return with an error message if initialization failed
        return back()->with('error', 'Payment initiation failed.');

    }

    /**
     * Handle Paystack's callback after payment.
     *
     * @param \Illuminate\Http\Request $request The request instance containing the payment reference.
     * @return \Illuminate\View\View Returns a success or error view based on payment status.
     */
    public function handleCallback(Request $request)
    {
        $reference = $request->query('reference'); // Get the payment reference from URL
        $client = new Client();

        // Verify the transaction with Paystack
        $response = $client->get($this->baseUrl . '/transaction/verify/' . $reference, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->secretKey,
            ]
        ]);

        $result = json_decode($response->getBody());
        // json_decode($response->getBody()->getContents(), true)

        $team = Team::find(current_company()->team->id);
        $subscription = $team->subscription('main');

        // Extract the subscription code (if available)
        $subscriptionCode = $result->data->plan->subscription_code ?? null;

        // If payment failed, store the transaction as "failed" and return an error page
        if (!$result->status || $result->data->status !== 'success') {
            Transaction::create([
                'team_id' => $team->id,
                'subscription_id' => $subscription->id,
                'reference' => $result->data->reference,
                'amount' => $result->data->amount / 100, // Convert back to major currency unit
                'currency' => 'KES',
                'status' => 'failed',
                'payment_method' => $result->data->channel,
                'metadata' => json_encode($result->data),
            ]);

            return view('app::paystack.error', ['message' => 'Payment failed. Please try again.']);
        }

        // Process the payment and update records within a database transaction
        DB::transaction(function () use ($subscription, $result, $team, $subscriptionCode) {
            // Update the subscription with the new billing period
            $subscription->update([
                'paystack_authorization' => $team->subscription('main')->paystack_authorization ?? $result->data->authorization->authorization_code,
                'paystack_customer' => $team->subscription('main')->paystack_customer ?? $result->data->customer->customer_code,
                'subscription_code' => $subscriptionCode,
                'invoice_period' => $result->data->metadata->invoice_period,
                'invoice_interval' => $result->data->metadata->invoice_interval,
                'starts_at' => now(),
                'ends_at' => calculateEndDate($result->data->metadata->invoice_interval, $result->data->metadata->invoice_period),
                'trial_ends_at' => null,
            ]);

            // Log the successful transaction
            Transaction::create([
                'team_id' => $team->id,
                'subscription_id' => $subscription->id,
                'reference' => $result->data->reference,
                'amount' => $result->data->amount / 100,
                'currency' => 'KES',
                'status' => 'success',
                'payment_method' => $result->data->channel,
                'metadata' => json_encode($result->data),
            ]);
        });

        // Return the success view with payment details
        return view('app::paystack.success', ['data' => $result->data]);
    }

    /**
     * Handle Paystack Webhook Events.
     *
     * @param \Illuminate\Http\Request $request The request containing the webhook payload.
     * @return \Illuminate\Http\JsonResponse Responds with a success or error message.
     */
    public function handle(Request $request)
    {
        // Verify webhook signature to ensure request authenticity
        $signature = $request->header('X-Paystack-Signature');

        if (!$signature || $signature !== hash_hmac('sha512', $request->getContent(), $this->secretKey)) {
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        // Decode and log the webhook payload
        $payload = $request->all();
        Log::info('Paystack Webhook Event:', $payload);

        // Handle different webhook event types
        if ($payload['event'] === 'charge.success') {
            $reference = $payload['data']['reference']; // Transaction reference
            $status = $payload['data']['status']; // Payment status
            $amount = $payload['data']['amount'] / 100; // Convert from kobo to major currency
            $teamId = $payload['data']['metadata']['team_id'] ?? null; // Retrieve team ID from metadata

            // Find and update the corresponding transaction record
            $transaction = Transaction::where('reference', $reference)->first();
            if ($transaction) {
                $transaction->update([
                    'status' => $status,
                    'processed_at' => now(),
                ]);
            }

            // If a valid team ID is present, update the team's subscription
            if ($teamId) {
                $subscription = PlanSubscription::find('subscriber_id', $teamId) ?? null;
                if ($subscription) {
                    $subscription->update([
                        'starts_at' => now(),
                        'ends_at' => calculateEndDate($subscription->invoice_interval),
                    ]);
                }
            }

            return response()->json(['message' => 'Payment processed successfully']);
        }

        // Return an error response if the event is not handled
        return response()->json(['message' => 'Event not handled'], 400);
    }


}
