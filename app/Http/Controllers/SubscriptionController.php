<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Gate;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $subscriptions = $request->user()
            ->subscriptions()
            ->with('category')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($request->category, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when($request->sort, function ($query, $sort) {
                [$column, $direction] = explode(',', $sort);
                $query->orderBy($column, $direction);
            }, function ($query) {
                $query->orderBy('renewal_date');
            })
            ->paginate(10)
            ->withQueryString();

        $categories = $request->user()->categories()->get();

        return Inertia::render('Subscriptions/Index', [
            'subscriptions' => $subscriptions,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category', 'sort']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Subscriptions/Create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'cost' => ['required', 'numeric', 'min:0'],
            'start_date' => ['required', 'date'],
            'renewal_date' => ['required', 'date', 'after_or_equal:start_date'],
            'frequency' => ['required', 'in:daily,weekly,monthly,quarterly,yearly'],
            'description' => ['nullable', 'string'],
            'website_url' => ['nullable', 'url'],
            'auto_renewal' => ['boolean'],
        ]);

        $subscription = $request->user()->subscriptions()->create($validated);

        // Create default notification setting
        $subscription->notificationSetting()->create([
            'user_id' => $request->user()->id,
            'reminder_days' => $request->user()->default_reminder_days,
        ]);

        return redirect()->route('subscriptions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription): RedirectResponse
    {
        Gate::authorize('update', $subscription);

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'cost' => ['required', 'numeric', 'min:0'],
            'start_date' => ['required', 'date'],
            'renewal_date' => ['required', 'date', 'after_or_equal:start_date'],
            'frequency' => ['required', 'in:daily,weekly,monthly,quarterly,yearly'],
            'description' => ['nullable', 'string'],
            'website_url' => ['nullable', 'url'],
            'auto_renewal' => ['boolean'],
        ]);

        $subscription->update($validated);

        return redirect()->route('subscriptions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription): RedirectResponse
    {
        Gate::authorize('delete', $subscription);

        $subscription->delete();

        return redirect()->route('subscriptions.index');
    }
}
