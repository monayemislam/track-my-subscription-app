<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'notification_email')) {
                $table->string('notification_email')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'notification_email_enabled')) {
                $table->boolean('notification_email_enabled')->default(true);
            }
            
            if (!Schema::hasColumn('users', 'notify_before_days')) {
                $table->json('notify_before_days')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'daily_digest_enabled')) {
                $table->boolean('daily_digest_enabled')->default(false);
            }
            
            if (!Schema::hasColumn('users', 'weekly_summary_enabled')) {
                $table->boolean('weekly_summary_enabled')->default(false);
            }
            
            if (!Schema::hasColumn('users', 'notification_time')) {
                $table->time('notification_time')->default('09:00:00');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'notification_email',
                'notification_email_enabled',
                'notify_before_days',
                'daily_digest_enabled',
                'weekly_summary_enabled',
                'notification_time',
            ]);
        });
    }
};
