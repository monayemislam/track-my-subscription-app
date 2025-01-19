<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionRenewalReminder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Subscription $subscription
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $daysUntilRenewal = now()->diffInDays($this->subscription->renewal_date);
        
        return (new MailMessage)
            ->subject("Subscription Renewal Reminder: {$this->subscription->name}")
            ->greeting("Hello {$notifiable->name}!")
            ->line("Your subscription to {$this->subscription->name} is due for renewal in {$daysUntilRenewal} days.")
            ->line("Renewal Date: {$this->subscription->renewal_date}")
            ->line("Amount: $" . number_format($this->subscription->cost, 2))
            ->action('View Subscription', url('/subscriptions'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
