<?php

declare(strict_types=1);

namespace Koverae\KoveraeBilling\Services\Billing;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;


class SubscriptionReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $channels;

    public function __construct(string $message, $channels)
    {
        $this->message = $message;
        $this->channels = $channels;
    }

    public function via($notifiable)
    {
        return $this->channels; // Dynamically decides channels
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Important: Subscription Reminder')
            ->line($this->message)
            ->action('Manage Subscription', route('subscribe'));
    }


    // public function toVonage($notifiable): VonageMessage
    // {
    //     return (new VonageMessage())
    //         ->content($this->message)
    //         ->from('Koverae Technologies');
    // }

    public function toArray($notifiable)
    {
        return ['message' => $this->message];
    }

}