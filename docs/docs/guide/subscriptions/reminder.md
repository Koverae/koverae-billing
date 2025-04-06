# 🔔 Reminder Service

The `ReminderService` handles the delivery of contextual notifications based on the subscription lifecycle of a user. It works in tandem with the `MessageTemplates` class to ensure users are gently reminded of upcoming renewals, trial expirations, or payment issues.

---


## Purpose

To **automatically notify** users about their subscription status at specific intervals using customized, friendly messages and preferred notification channels.

---

## How It Works

When you call the `sendReminder()` method with a `PlanSubscription` instance and a `status`, the service:

1. **Calculates** how many days are left (or passed) relative to the subscription's `ends_at` date.
2. **Checks** if the current day matches a configured reminder day.
3. **Fetches** the user attached to the subscription.
4. **Generates** a message using the `MessageTemplates::getMessage()` method.
5. **Sends** a notification using Laravel's `Notification` system.

---

## Method Overview

```php
    public function sendReminder(PlanSubscription $subscription, string $status)
    {
        $daysLeft = now()->diffInDays($subscription->ends_at, false);

        // Get scheduled days for this status
        $scheduleDays = config("koverae-billing.reminders.{$status}", []);

        if (!in_array($daysLeft, $scheduleDays)) {
            return; // Skip if not a scheduled reminder day
        }

        $user = $subscription->user;
        $message = MessageTemplates::getMessage($status, (int) $daysLeft, $user);
        $channels = config('koverae-billing.notification_channels', ['mail']);

        Notification::send($user, new SubscriptionReminderNotification($message, $channels));
    }
```

### Parameters:

- `PlanSubscription $subscription`: The user's subscription instance.

- `string $status`: One of `trial`, `renewal`, `grace_period`, or `failed_payment`.

<details>
<summary>Click me to view example code</summary>

```php
use Koverae\KoveraeBilling\Services\Billing\ReminderService;

$subscription = PlanSubscription::find(1);
app(ReminderService::class)->sendReminder($subscription, 'trial');
```
</details> 

## Configuration
Configure reminder schedules in your `config/koverae-billing.php`:
```php
'reminders' => [
    'trial' => [2, 1, 0, -1],
    'renewal' => [5, 2, 0, -1],
    'grace_period' => [-2, -5],
    'failed_payment' => [0],
],
```

### Notification Channels
```php
'notification_channels' => ['mail', 'database', 'vonage'],
```

## Custom Notifications
Make sure to have a custom `SubscriptionReminderNotification` that accepts:
```php
new SubscriptionReminderNotification($message, $channels);
```
This allows for multiple delivery channels like email, database, SMS, or Slack.

## Tip
Use it with your task scheduler to automate reminders daily:
```php
// In your console Kernel
$schedule->call(function () {
    PlanSubscription::active()->each(function ($subscription) {
        app(ReminderService::class)->sendReminder($subscription, 'renewal');
    });
})->daily();
```

## Blade Snippet Example
```blade
@php
    use Koverae\KoveraeBilling\Services\Billing\MessageTemplates;

    $subscription = auth()->user()?->subscription('main');
    $daysLeft = now()->diffInDays($subscription?->ends_at, false);
    $status = $subscription?->getStatusForReminder(); // You can create this helper on your model

    $message = $status 
        ? MessageTemplates::getMessage($status, $daysLeft, auth()->user()) 
        : null;
@endphp

@if($message)
    <div class="rounded-md bg-yellow-100 p-4 my-4 border border-yellow-300 text-yellow-800">
        <strong class="block font-semibold">📢 Subscription Notice</strong>
        <span>{{ $message }}</span>
    </div>
@endif
```