<?php

declare(strict_types=1);

namespace Koverae\KoveraeBilling\Services\Billing;

class MessageTemplates
{
    public static function getMessage(string $status, int $daysLeft, $user): string
    {
        return match ($status) {
            'trial' => self::getTrialReminder($daysLeft, $user),
            'renewal' => self::getRenewalReminder($daysLeft, $user),
            'grace_period' => self::getGracePeriodReminder($daysLeft, $user),
            'failed_payment' => self::getFailedPaymentReminder($user),
            default => "Your subscription status has an important update.",
        };
    }

    private static function getTrialReminder(int $daysLeft, $user): string
    {
        return match ($daysLeft) {
            2 => "Hey {$user->name}, your Ndako free trial has 2 days left! Love it? Renew today.",
            1 => "Your free trial ends tomorrow, {$user->name}. Subscribe now to keep access.",
            0 => "Your trial ends today! Subscribe now to continue using Ndako.",
            -1 => "Your trial ended yesterday. Reactivate to stay connected.",
            default => "Your trial is ending soon! Don't miss out.",
        };
    }

    private static function getRenewalReminder(int $daysLeft, $user): string
    {
        return match ($daysLeft) {
            5 => "Your subscription renews in 5 days. Need changes? Visit billing settings.",
            2 => "Reminder: Your Ndako subscription renews in 2 days. Update payment details!",
            0 => "Your renewal is due today, {$user->name}. Need help? We're here!",
            -1 => "Your renewal was missed yesterday. Reactivate to avoid disruption.",
            default => "Your subscription renews soon! Stay with Ndako.",
        };
    }

    private static function getGracePeriodReminder(int $daysLeft, $user): string
    {
        return match ($daysLeft) {
            -2 => "You're in a grace period, {$user->name}. Renew now to avoid losing access.",
            -5 => "Final notice: Your grace period ends soon. Reactivate to continue using Ndako.",
            default => "Your subscription is inactive. Renew now to regain access.",
        };
    }

    private static function getFailedPaymentReminder($user): string
    {
        return "Payment issue detected! Update your billing details to avoid service interruption.";
    }
    
}