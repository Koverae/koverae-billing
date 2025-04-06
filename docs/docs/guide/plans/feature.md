# Plan Feature

This model relates to which features has a Plan. This features will be attached to every new subscription.

## Create plan features
Features are things that your plan allows subscribers to do. The obligatory fields are: `tag`, `name`, and `value`. The value of the feature tells if or how many times the subscriber is allowed to use it. When setting a feature that should be active or not, use written strings 'true' or 'false', otherwise use an integer to tell how many times it can be used. If in the higher plan you want to give unlimited access to the "counted" feature, use 'true' as well. If you want the usage of features to be reset on a regular basis, provide optional `resettable_period` and `resettable_interval` fields.

```php
use Koverae\KoveraeBilling\Models\Plan;

$plan = Plan::find(1);

// Create multiple plan features at once
$plan->features()->saveMany([
    new PlanFeature([
        'tag' => 'api_requests',
        'name' => 'API Requests per Month',
        'value' => 10000,
        'sort_order' => 2,
        'resettable_period' => 1,
        'resettable_interval' => 'month',
    ]),
    new PlanFeature([
        'tag' => 'storage_limit',
        'name' => 'Storage Limit (MB)',
        'value' => 5120,
        'sort_order' => 5,
    ]),
    new PlanFeature([
        'tag' => 'team_members',
        'name' => 'Team Members Allowed',
        'value' => 5,
        'sort_order' => 7,
    ]),
    new PlanFeature([
        'tag' => 'priority_support',
        'name' => 'Priority Support',
        'value' => true,
        'sort_order' => 20,
    ]),
    new PlanFeature([
        'tag' => 'custom_branding',
        'name' => 'Custom Branding',
        'value' => false,
        'sort_order' => 25,
    ]),
]);
```

### Sort order
`sort_order` column has no logic in package, it is just a field for you to use in your queries.

## Get Plan Feature value
Say you want to show the value of the feature posts_per_social_profile from above. You can do so in many ways:

```php
use Koverae\KoveraeBilling\Models\Plan;
use Koverae\KoveraeBilling\Models\PlanFeature;
use Koverae\KoveraeBilling\Models\PlanSubscription;

$plan = Plan::find(1);

// From the plan instance
$teamLimit = $plan->getFeatureByTag('team_members')->value;

// Query the feature directly
$teamLimit = PlanFeature::where('tag', 'team_members')->first()->value;

// From the subscription instance
$teamLimit = PlanSubscription::find(1)->getFeatureValue('team_members');
```

## Feature Options
Plan features are great for fine-tuning subscriptions, you can top up certain feature for X times of usage, so users may then use it only for that amount. Features also have the ability to be resettable and then it's usage could be expired too. See the following examples:

```php
use Koverae\KoveraeBilling\Models\PlanFeature;

// Find plan feature
$feature = PlanFeature::where('tag', 'team_members')->first();

// Get feature reset date
$feature->getResetDate(new \Carbon\Carbon());
```
