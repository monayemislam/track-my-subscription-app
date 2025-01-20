<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();
        
        $totalSubscriptions = $user->subscriptions()->count();
        $weeklyCost = $user->subscriptions()
            ->where('frequency', 'weekly')
            ->sum('cost');
        $monthlyCost = $user->subscriptions()
            ->where('frequency', 'monthly')
            ->sum('cost');
        $quarterlyCost = $user->subscriptions()
            ->where('frequency', 'quarterly')
            ->sum('cost');
        $yearlyCost = $user->subscriptions()
            ->where('frequency', 'yearly')
            ->sum('cost');
            
        $upcomingRenewals = $user->subscriptions()
            ->where('renewal_date', '<=', now()->addDays($user->default_reminder_days))
            ->with('category')
            ->get();
            
        $categoryBreakdown = $user->subscriptions()
            ->with('category')
            ->get()
            ->groupBy('category.name')
            ->map(fn($group) => $group->sum('cost'));

        return Inertia::render('Dashboard', [
            'stats' => [
                'totalSubscriptions' => $totalSubscriptions,
                'weeklyCost' => $weeklyCost,
                'monthlyCost' => $monthlyCost,
                'quarterlyCost' => $quarterlyCost,
                'yearlyCost' => $yearlyCost,
                'upcomingRenewals' => $upcomingRenewals,
                'categoryBreakdown' => $categoryBreakdown,
            ],
        ]);
    }
}
