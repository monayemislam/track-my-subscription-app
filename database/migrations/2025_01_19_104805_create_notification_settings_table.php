<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subscription_id')->constrained()->onDelete('cascade');
            $table->integer('reminder_days')->default(7);
            $table->boolean('email_enabled')->default(true);
            $table->timestamps();
            
            $table->unique(['user_id', 'subscription_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
