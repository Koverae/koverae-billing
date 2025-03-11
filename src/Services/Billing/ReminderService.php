<?php

declare(strict_types=1);

namespace Koverae\KoveraeBilling\Services\Billing;

use Illuminate\Support\Facades\Notification;
use Koverae\KoveraeBilling\Models\PlanSubscription;


class ReminderService
{

    /**
     * Send a reminder based on subscription status
     */
    public function sendReminder(PlanSubscription $subscription, string $status)
    {
        $daysLeft = now()->diffInDays($subscription->ends_at, false);

        // Get scheduled days for this status
        $scheduleDays = config("billing.reminders.{$status}", []);

        if (!in_array($daysLeft, $scheduleDays)) {
            return; // Skip if not a scheduled reminder day
        }

        $user = $subscription->user;
        $message = MessageTemplates::getMessage($status, (int) $daysLeft, $user);
        $channels = config('billing.notification_channels', ['mail']);

        Notification::send($user, new SubscriptionReminderNotification($message, $channels));
    }


}