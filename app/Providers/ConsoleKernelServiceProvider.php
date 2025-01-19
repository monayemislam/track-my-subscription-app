<?php

namespace App\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ConsoleKernelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            
            // Schedule the subscription reminders to run daily
            $schedule->command('subscriptions:send-reminders')->daily();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
