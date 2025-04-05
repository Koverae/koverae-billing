# Plan Combination

With this model you define your plan combinations. You can have multiple prices and intervals per currency, country, etc.


## Create a Plan Combination
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
