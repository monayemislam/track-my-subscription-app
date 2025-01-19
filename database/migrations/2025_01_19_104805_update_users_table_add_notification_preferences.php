<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('default_reminder_days')->default(7);
            $table->boolean('email_notifications_enabled')->default(true);
            $table->timestamp('last_notification_sent_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['default_reminder_days', 'email_notifications_enabled', 'last_notification_sent_at']);
        });
    }
};
