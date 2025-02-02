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
        
        // Debug the query first
        \Log::info('Checking subscription breakdown query');
        
        // Get subscription breakdown data using SQLite compatible date formatting
        $subscriptionBreakdown = $user->subscriptions()
            ->select(
                DB::raw('strftime("%Y-%m", renewal_date) as month'),
                DB::raw('SUM(cost) as total_cost')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->month => (float) $item->total_cost];
            })
            ->toArray();

        // Log the breakdown data to verify
        \Log::info('Subscription Breakdown:', $subscriptionBreakdown);

        // Get category breakdown
        $categoryBreakdown = $user->subscriptions()
            ->select('categories.name', DB::raw('SUM(subscriptions.cost) as total_cost'))
            ->join('categories', 'categories.id', '=', 'subscriptions.category_id')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('categories.name')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->name => (float) $item->total_cost];
            })
            ->toArray();

        // Calculate subscription costs by frequency
        $subscriptionCosts = [
            'weekly' => $user->subscriptions()
                ->where('frequency', 'weekly')
                ->sum('cost'),
            'monthly' => $user->subscriptions()
                ->where('frequency', 'monthly')
                ->sum('cost'),
            'quarterly' => $user->subscriptions()
                ->where('frequency', 'quarterly')
                ->sum('cost'),
            'yearly' => $user->subscriptions()
                ->where('frequency', 'yearly')
                ->sum('cost')
        ];

        return Inertia::render('Dashboard', [
            'stats' => [
                'subscriptionCosts' => $subscriptionCosts,
                'totalSubscriptions' => $user->subscriptions()->count(),
                'subscriptionBreakdown' => $subscriptionBreakdown,
                'categoryBreakdown' => $categoryBreakdown,
                'upcomingRenewals' => $user->subscriptions()
                    ->with('category')
                    ->whereDate('renewal_date', '>=', now())
                    ->whereDate('renewal_date', '<=', now()->addDays(7))
                    ->orderBy('renewal_date')
                    ->get()
            ],
        ]);
    }
}
