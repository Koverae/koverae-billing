# 📬 Message Templates

The `MessageTemplates` service provides friendly, contextual messages related to user subscription events. These messages can be used in notifications, banners, or emails to inform users about their subscription status.

> 🧠 Use them in **notifications**, **emails**, **dashboards**, or **banners** to guide users through trials, renewals, grace periods, or payment issues.

## How it works
Use the static `getMessage()` method to automatically generate the appropriate message based on:

- Status: `trial`, `renewal`, `grace_period`, or `failed_payment`

- Days left before/after a key event

- The user instance
```php
use Koverae\KoveraeBilling\Services\Billing\MessageTemplates;

$message = MessageTemplates::getMessage('trial', 2, $user);
```

## Supported Message Types

### Trial Period
- 2 days left → "Hey John, your Ndako free trial has 2 days left! Love it? Renew today."

- 1 day left → "Your free trial ends tomorrow, John. Subscribe now to keep access."

- Ends today → "Your trial ends today! Subscribe now to continue using Ndako."

- Ended yesterday → "Your trial ended yesterday. Reactivate to stay connected."

### Renewal Reminder
- 5 days before → "Your subscription renews in 5 days. Need changes? Visit billing settings."

- 2 days before → "Reminder: Your Ndako subscription renews in 2 days. Update payment details!"

- Due today → "Your renewal is due today, John. Need help? We're here!"

- Missed yesterday → "Your renewal was missed yesterday. Reactivate to avoid disruption."

### Grace Period
- 2 days in → "You're in a grace period, John. Renew now to avoid losing access."

- 5 days in → "Final notice: Your grace period ends soon. Reactivate to continue using Ndako."

- Default → "Your subscription is inactive. Renew now to regain access."

### Failed Payment
- Always → "Payment issue detected! Update your billing details to avoid service interruption."