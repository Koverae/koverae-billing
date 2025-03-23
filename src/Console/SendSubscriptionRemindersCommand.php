<?php

declare(strict_types=1);

namespace Koverae\KoveraeBilling\Console;

use Illuminate\Console\Command;
use Koverae\KoveraeBilling\Models\PlanSubscription;
use Koverae\KoveraeBilling\Services\Billing\ReminderService;

class SendSubscriptionRemindersCommand extends Command
{
    protected $signature = 'billing:send-reminders';
    protected $description = 'Send reminders for all subscription types';

    public function handle(ReminderService $reminderService)
    {
        $statuses = ['trial', 'renewal', 'grace_period', 'failed_payment'];

        foreach ($statuses as $status) {
            $subscriptions = PlanSubscription::where('status', $status)->get();

            foreach ($subscriptions as $subscription) {
                $reminderService->sendReminder($subscription, $status);
            }
        }

        $this->info('Subscription reminders sent successfully.');

        // $schedule->command('billing:send-reminders')->dailyAt('10:00');
    }
}
