<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('cost', 10, 2);
            $table->date('start_date');
            $table->date('renewal_date');
            $table->enum('frequency', ['daily', 'weekly', 'monthly', 'quarterly', 'yearly']);
            $table->text('description')->nullable();
            $table->string('website_url')->nullable();
            $table->boolean('auto_renewal')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
