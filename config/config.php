<?php

declare(strict_types=1);


return [
    'main_subscription_tag' => 'main',
    'fallback_plan_tag' => null,

    // Database Tables
    'tables' => [
        'plans' => 'plans',
        'plan_features' => 'plan_features',
        'plan_subscriptions' => 'plan_subscriptions',
        'plan_subscription_features' => 'plan_subscription_features',
        'plan_subscription_schedules' => 'plan_subscription_schedules',
        'plan_subscription_usage' => 'plan_subscription_usage',
    ],

    // Models
    'models' => [
        'plan' => '',
        'plan_feature' => '',
        'plan_subscription' => '',
        'plan_subscription_feature' => '',
        'plan_subscription_schedule' => '',
        'plan_subscription_usage' => '',
    ],

    'services' => [
        'payment_methods' => [
            'free' => '',
            'm-pesa' => '',
            'credit_card' => '',
        ]
    ]
];
