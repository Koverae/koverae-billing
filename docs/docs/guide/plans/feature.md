# Plan Feature

This model relates to which features has a Plan. This features will be attached to every new subscription.

## Create plan features
Features are things that your plan allows subscribers to do. The obligatory fields are: `tag`, `name`, and `value`. The value of the feature tells if or how many times the subscriber is allowed to use it. When setting a feature that should be active or not, use written strings 'true' or 'false', otherwise use an integer to tell how many times it can be used. If in the higher plan you want to give unlimited access to the "counted" feature, use 'true' as well. If you want the usage of features to be reset on a regular basis, provide optional `resettable_period` and `resettable_interval` fields.

```php
use Bpuig\Subby\Models\Plan;

$plan = Plan::find(1);

// Create multiple plan features at once
$plan->features()->saveMany([
    new PlanFeature(['tag' => 'social_profiles', 'name' => 'Social profiles available', 'value' => 3, 'sort_order' => 1]),
    new PlanFeature(['tag' => 'posts_per_social_profile', 'name' => 'Scheduled posts per profile', 'value' => 30, 'sort_order' => 10, 'resettable_period' => 1, 'resettable_interval' => 'month']),
    new PlanFeature(['tag' => 'analytics', 'name' => 'Analytics', 'value' => true, 'sort_order' => 15])
]);
```

### Sort order

## Get Plan Feature value

## Feature Options
Combinations must be unique for country, currency, invoice_period and invoice_interval.

```php
use Koverae\KoveraeBilling\Models\Plan;
use Koverae\KoveraeBilling\Models\PlanCombination;

$plan = Plan::getByTag('basic');

$plan->combinations()->create([
    'tag' => 'basic-ug-ugx-1-year',
    'country' => 'UGA',
    'currency' => 'UGX',
    'price' => 99900,
    'invoice_period' => 1,
    'invoice_interval' => 'year',
]);
```

## Get Plan Combination details
You can query the plan combination for further details as follows:

```php
$planCombination = PlanCombination::find(1);

// Or querying by tag
$planCombination = PlanCombination::getByTag('basic-ug-ugx-1-year');

// Or do your own query
$plan = Plan::getByTag('basic');

$planCombination = $plan->combinations()->where('country', 'UGA')
                                        ->where('currency', 'UGX')
                                        ->where('invoice_period', 1)
                                        ->where('invoice_interval', 'year')
                                        ->first();

// Get parent plan                
$planCombination->plan;
```

## Subscribe to plan combination
See [create a Subscription](/guide/subscriptions/subscription#create-subscription) and use a `PlanCombination` instead of a `Plan`.


## Change subscription's plan to plan combination
See [change its plan](/guide/subscriptions/subscription#change-its-plan) and use a `PlanCombination` instead of a `Plan`.

## Schedule subscription's plan change to plan combination
See [create schedule](/guide/subscriptions/schedule#create-schedule) and use a `PlanCombination` instead of a `Plan`.
