<?php

declare(strict_types=1);


return [

    'main_subscription_tag' => 'main',
    'fallback_plan_tag' => null,
    // Database Tables
    'tables' => [
        'plans' => 'plans',
        'plan_combinations' => 'plan_combinations',
        'plan_features' => 'plan_features',
        'plan_subscriptions' => 'plan_subscriptions',
        'plan_subscription_features' => 'plan_subscription_features',
        'plan_subscription_schedules' => 'plan_subscription_schedules',
        'plan_subscription_usage' => 'plan_subscription_usage',
        'transactions' => 'transactions',
    ],

    // Models
    'models' => [
        'plan' => \Koverae\KoveraeBilling\Models\Plan::class,
        'plan_combination' => \Koverae\KoveraeBilling\Models\PlanCombination::class,
        'plan_feature' => \Koverae\KoveraeBilling\Models\PlanFeature::class,
        'plan_subscription' => \Koverae\KoveraeBilling\Models\PlanSubscription::class,
        'plan_subscription_feature' => \Koverae\KoveraeBilling\Models\PlanSubscriptionFeature::class,
        'plan_subscription_schedule' => \Koverae\KoveraeBilling\Models\PlanSubscriptionSchedule::class,
        'plan_subscription_usage' => \Koverae\KoveraeBilling\Models\PlanSubscriptionUsage::class,
        'transaction' => \Koverae\KoveraeBilling\Models\Transaction::class,
    ],

    'services' => [
        'payment_methods' => [
            'free' => \Koverae\KoveraeBilling\Services\PaymentMethods\Free::class,
            'paystack' =>  \Koverae\KoveraeBilling\Services\PaymentMethods\Paystack::class,
            'paypal' =>  '',
        ],
        'reminders' => [
            'send_reminder' => \Koverae\KoveraeBilling\Services\Billing\ReminderService::class,
        ],
    ],

    'reminders' => [
        'trial' => [2, 1, 0, -1], // Days before/after trial ends
        'renewal' => [5, 2, 0, -1], // Days before/after renewal
        'grace_period' => [-2, -5], // Days after expiration but before deactivation
        'failed_payment' => [0, -3, -7], // Days after failed payment
    ],
    'notification_channels' => [
        'mail',
        'database',
        // 'vonage'
    ], // Define active channels

    // PAYSTACK
    'paystack' => [
        'public_key' => env('PAYSTACK_PUBLIC_KEY'),
        'secret_key' => env('PAYSTACK_SECRET_KEY'),
        'base_url' => env('PAYSTACK_PAYMENT_URL', 'https://api.paystack.co'),
        'merchand_email' => env('PAYSTACK_MERCHANT_EMAIL'),
    ],

    // KOVERAE TECHNOLOGIES
    'koverae' => [
        'public_key' => env('KOVERAE_PUBLIC_KEY', ''),
        'secret_key' => env('KOVERAE_SECRET_KEY', ''),
        'base_url' => env('KOVERAE_PAYMENT_URL', 'https://api.koverae.com'),
    ]

];
