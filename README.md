![Koverae Billing](https://github.com/Koverae/koverae-billing/blob/main/public/images/koverae-billing.png)


[![Latest Version on Packagist](https://img.shields.io/packagist/v/koverae/koverae-billing.svg?style=flat-square)](https://packagist.org/packages/koverae/koverae-billing)
[![Total Downloads](https://img.shields.io/packagist/dt/koverae/koverae-billing.svg?style=flat-square)](https://packagist.org/packages/koverae/koverae-billing)
![GitHub Actions](https://github.com/koverae/koverae-billing/actions/workflows/main.yml/badge.svg)

[![Sparkline](https://stars.medv.io/bavix/laravel-wallet.svg)](https://stars.medv.io/bavix/laravel-wallet)

Koverae Billing - Manage plans, trials, and payments with clean, extensible logic.

[[Documentation](https://devs.koverae.com/koverae-billing/)] 
[[Get Started](https://devs.koverae.com/koverae-billing/guide/introduction/)] 

* **Vendor**: koverae
* **Package**: koverae-billing
* **[Composer](https://getcomposer.org/):** `composer require koverae/koverae-billing`

### Support Policy

| Version    | Laravel        | PHP             | Release date | End of improvements | End of support      |
|------------|----------------|-----------------|--------------|---------------------|----------------|
| 1.x [LTS] | ^11.0, ^12.0   | 8.2,8.3,8.4     | Apr 07, 2025 | May 1, 2026         | Sep 6, 2026    |

### Upgrade Guide

To perform the migration, you will be [helped by the instruction](https://devs.koverae.com/koverae-billing/#/upgrade-guide).

### Community

I want to create a cozy place for developers using the Koverae Billing package. This will help you find bugs faster, get feedback and discuss ideas.

![telegram](https://github.com/Koverae/koverae-billing/blob/main/public/images/billing-telegram.jpg)


Telegram: [@koverae_billing](https://t.me/koverae_billing)

### Usage
Once installed and configured, using `koverae-billing` is straightforward and developer-friendly.

#### Models
`koverae-billing` uses this models:

```php
Koverae\KoveraeBilling\Models\Plan;
Koverae\KoveraeBilling\Models\PlanCombination;
Koverae\KoveraeBilling\Models\PlanFeature;
Koverae\KoveraeBilling\Models\PlanSubscription;
Koverae\KoveraeBilling\Models\PlanSubscriptionFeature;
Koverae\KoveraeBilling\Models\PlanSubscriptionSchedule;
Koverae\KoveraeBilling\Models\PlanSubscriptionUsage;
```

#### Add Billing Support to a Model

To start, add the `HasSubscriptions` trait to any model you want to make billable (typically the `User` model):

```php
use Koverae\KoveraeBilling\Concerns\HasSubscriptions;

class User extends Authenticatable
{
    use HasSubscriptions;
}
```

#### Subscribing a User to a Plan

You can subscribe a user (or any model correctly traited) to a plan by using the newSubscription() function available in the HasSubscriptions trait. First, retrieve an instance of your subscriber's model, which typically will be your user model and an instance of the plan your subscriber is subscribing to. Once you have retrieved the model instance, you may use the newSubscription method to create the model's subscription.

```php
$user = User::find(1);
$plan = Plan::find(1);

$user->newSubscription(
            'main', // identifier tag of the subscription. If your application offers a single subscription, you might call this 'main' or 'primary'
             $plan, // Plan or PlanCombination instance your subscriber is subscribing to
             'Main subscription', // Human-readable name for your subscription
             'Customer main subscription', // Description
             null, // Start date for the subscription, defaults to now()
             'free' // Payment method service defined in config
             );
```

### Checking a User’s Subscription
For a subscription to be considered active one of the following must be true:
- Subscription has an active trial.
- Subscription `ends_at` is in the future.

Alternatively you can use the following methods available in the subscription model:

```php
$user->subscription('main')->isActive();
$user->subscription('main')->isCanceled();
$user->subscription('main')->hasEnded();
$user->subscription('main')->hasEndedTrial();
$user->subscription('main')->isOnTrial();

// To know if subscription has the same values as related plan or has been changed
$user->subscription('main')->isAltered();
```

### Cancel or Resume a Subscription
#### Renew a Subscription
To renew a subscription you may use the `renew` method available in the subscription model. This will set a new `ends_at` date based on the selected plan.

```php
$user->subscription('main')->renew();

$user->subscription('main')->renew(3); // This will triple the periods. CAUTION: If your subscription is 2 'month', you'll get 6 'month'
```

Canceled subscriptions can't be renewed. Renewing a subscription with trial period ends it.

When a subscription has already ended time ago and now is renewed, period will be set as if subscription started today, but when a subscription is still ongoing and renewed, start date is kept and end date is extended by the amount of periods specified

#### Cancel a Subscription

To cancel a subscription, simply use the cancel method on the user's subscription:

```php
$user->subscription('main')->cancel();
```

##### Immediatly
By default the subscription will remain active until the end of the period, you may pass true to end the subscription immediately:

```php
$user->subscription('main')->cancel(true);
```

##### Fallback plan
If a `fallback_plan_tag` is not `null` in config, when `cancel` is called, subscription will not be canceled but changed to fallback plan.

To cancel subscription and ignore fallback, a second parameter is available on `cancel` method:

```php
$user->subscription('main')->cancel(false, true);
```

#### Uncancel a Subscription
To uncancel a subscription, simply use the `uncancel` method on the user's subscription:

```php
$user->subscription('main')->uncancel();
```

#### Scopes

```php
// Get subscriptions by plan
$subscriptions = PlanSubscription::byPlanId($planId)->get();

// Get bookings of the given user
$user = \App\Models\User::find(1);
$bookingsOfUser = PlanSubscription::ofSubscriber($user)->get(); 

// Get subscriptions with trial ending in 3 days
$subscriptions = PlanSubscription::findEndingTrial(3)->get();

// Get subscriptions with ended trial
$subscriptions = PlanSubscription::findEndedTrial()->get();

// Get subscriptions with period ending in 3 days
$subscriptions = PlanSubscription::findEndingPeriod(3)->get();

// Get subscriptions with ended period
$subscriptions = PlanSubscription::findEndedPeriod()->get();

// Get subscriptions with period ending in 3 days filtered by the subscription tag
$subscriptions = PlanSubscription::getByTag('company')->findEndingPeriod(3)->get();
```

## Contributors

### Code Contributors

This project exists thanks to all the people who contribute. [[Contribute](CONTRIBUTING.md)].

-   [Arden BOUET](https://github.com/arden28)
-   [All Contributors](../../contributors)


## License

Forked originally from [bpuig/laravel-subby](https://github.com/bpuig/laravel-subby). Thank you for
creating the original! :)

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

&copy; 2025 | Arden BOUET, Some rights reserved.
