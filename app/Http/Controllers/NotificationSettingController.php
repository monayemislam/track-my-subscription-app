<?php

namespace App\Http\Controllers;

use App\Models\NotificationSetting;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationSettingController extends Controller
{
    public function update(Request $request, Subscription $subscription): RedirectResponse
    {
        $this->authorize('update', $subscription);

        $validated = $request->validate([
            'reminder_days' => ['required', 'integer', 'min:1', 'max:90'],
            'email_enabled' => ['required', 'boolean'],
        ]);

        $subscription->notificationSetting()->updateOrCreate(
            ['subscription_id' => $subscription->id],
            $validated
        );

        return back();
    }

    public function updateUserDefaults(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'default_reminder_days' => ['required', 'integer', 'min:1', 'max:90'],
            'email_notifications_enabled' => ['required', 'boolean'],
        ]);

        $request->user()->update($validated);

        return back();
    }

    public function getDefaults(Request $request)
    {
        $user = Auth::user();
        
        return Inertia::render('NotificationSettings/Index', [
            'defaults' => [
                'reminder_days' => (int) ($user->default_reminder_days ?? 7),
                'email_enabled' => (bool) ($user->notification_email_enabled ?? true),
                'notify_before_days' => $user->notify_before_days ?? [1, 3, 7],
                'daily_digest_enabled' => (bool) ($user->daily_digest_enabled ?? false),
                'weekly_summary_enabled' => (bool) ($user->weekly_summary_enabled ?? false),
                'notification_time' => $user->notification_time ? date('H:i', strtotime($user->notification_time)) : '09:00',
            ],
            'user' => [
                'email' => $user->email,
                'notification_email' => $user->notification_email ?? $user->email,
            ],
        ]);
    }

    public function updateDefaults(Request $request)
    {
        $validated = $request->validate([
            'reminder_days' => ['required', 'integer', 'min:1', 'max:90'],
            'email_enabled' => ['required', 'boolean'],
            'notification_email' => ['required', 'email'],
            'notify_before_days' => ['array'],
            'notify_before_days.*' => ['integer', 'min:1', 'max:90'],
            'daily_digest_enabled' => ['boolean'],
            'weekly_summary_enabled' => ['boolean'],
            'notification_time' => ['required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'],
        ]);

        try {
            $user = Auth::user();
            
            $updated = $user->update([
                'default_reminder_days' => (int) $validated['reminder_days'],
                'notification_email_enabled' => $validated['email_enabled'],
                'notification_email' => $validated['notification_email'],
                'notify_before_days' => $validated['notify_before_days'] ?? [1, 3, 7],
                'daily_digest_enabled' => $validated['daily_digest_enabled'] ?? false,
                'weekly_summary_enabled' => $validated['weekly_summary_enabled'] ?? false,
                'notification_time' => $validated['notification_time'],
            ]);

            if (!$updated) {
                throw new \Exception('Failed to update settings');
            }

            return back()->with('success', 'Notification settings updated successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update settings: ' . $e->getMessage()]);
        }
    }
}
