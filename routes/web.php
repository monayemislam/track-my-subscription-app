<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationSettingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('subscriptions', SubscriptionController::class);
    
    // Fix notification settings routes
    Route::get('/notification-settings/defaults', 
        [NotificationSettingController::class, 'getDefaults'])
        ->name('notification-settings.defaults');
        
    Route::patch('/notification-settings/defaults', 
        [NotificationSettingController::class, 'updateDefaults'])
        ->name('notification-settings.update-defaults');
        
    Route::patch('/subscriptions/{subscription}/notification-settings', 
        [NotificationSettingController::class, 'update'])
        ->name('notification-settings.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class)
        ->except(['create', 'edit', 'show']);
});

require __DIR__.'/auth.php';
