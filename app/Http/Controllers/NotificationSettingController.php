<?php

namespace App\Http\Controllers;

use App\Models\NotificationSetting;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationSettingController extends Controller
{
    public function update(Request $request, Subscription $subscription): RedirectResponse
    {
        $this->authorize('update', $subscription);

        $validated = $request->validate([
            'reminder_days' => ['required', 'integer', 'min:1', 'max:90'],
            'email_enabled' => ['required', 'boolean'],
        ]);

        $subscription->notificationSetting()->update($validated);

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
        return response()->json([
            'reminder_days' => $request->user()->default_reminder_days,
            'email_enabled' => $request->user()->notification_email_enabled,
        ]);
    }
}
