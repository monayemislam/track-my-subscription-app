<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Notifications\SubscriptionRenewalReminder;
use Illuminate\Console\Command;

class SendRenewalReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send renewal reminders for upcoming subscription renewals';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $subscriptions = Subscription::with(['user', 'notificationSetting'])
            ->whereHas('notificationSetting', function ($query) {
                $query->where('email_enabled', true);
            })
            ->whereHas('user', function ($query) {
                $query->where('email_notifications_enabled', true);
            })
            ->get();

        foreach ($subscriptions as $subscription) {
            $daysUntilRenewal = now()->diffInDays($subscription->renewal_date, false);
            $reminderDays = $subscription->notificationSetting->reminder_days;

            if ($daysUntilRenewal > 0 && $daysUntilRenewal <= $reminderDays) {
                // Check if we haven't sent a notification recently
                if (!$subscription->user->last_notification_sent_at || 
                    now()->diffInHours($subscription->user->last_notification_sent_at) >= 24) {
                    
                    $subscription->user->notify(new SubscriptionRenewalReminder($subscription));
                    
                    $subscription->user->update([
                        'last_notification_sent_at' => now()
                    ]);
                }
            }
        }

        $this->info('Renewal reminders sent successfully!');
    }
}
