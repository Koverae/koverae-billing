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
            'm-pesa' =>  '',
            'credit_card' => '',
        ]
    ]
];
