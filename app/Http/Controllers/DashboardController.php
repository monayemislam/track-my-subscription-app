<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();
        
        // Get basic stats
        $totalSubscriptions = $user->subscriptions()->count();
        
        // Get costs by frequency
        $weeklyCost = $user->subscriptions()->where('billing_frequency', 'weekly')->sum('cost');
        $monthlyCost = $user->subscriptions()->where('billing_frequency', 'monthly')->sum('cost');
        $quarterlyCost = $user->subscriptions()->where('billing_frequency', 'quarterly')->sum('cost');
        $yearlyCost = $user->subscriptions()->where('billing_frequency', 'yearly')->sum('cost');

        // Get subscription breakdown by cost
        $subscriptionBreakdown = $user->subscriptions()
            ->select('name', 'cost')
            ->orderByDesc('cost')
            ->pluck('cost', 'name')
            ->toArray();

        // Get category breakdown
        $categoryBreakdown = $user->subscriptions()
            ->select('categories.name', DB::raw('SUM(subscriptions.cost) as total_cost'))
            ->join('categories', 'categories.id', '=', 'subscriptions.category_id')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_cost')
            ->pluck('total_cost', 'name')
            ->toArray();

        // Get upcoming renewals
        $upcomingRenewals = $user->subscriptions()
            ->with('category')
            ->whereDate('renewal_date', '>=', now())
            ->whereDate('renewal_date', '<=', now()->addDays(7))
            ->orderBy('renewal_date')
            ->get();

        return Inertia::render('Dashboard', [
            'stats' => [
                'totalSubscriptions' => $totalSubscriptions,
                'weeklyCost' => $weeklyCost,
                'monthlyCost' => $monthlyCost,
                'quarterlyCost' => $quarterlyCost,
                'yearlyCost' => $yearlyCost,
                'subscriptionBreakdown' => $subscriptionBreakdown,
                'categoryBreakdown' => $categoryBreakdown,
                'upcomingRenewals' => $upcomingRenewals,
            ],
        ]);
    }
}
