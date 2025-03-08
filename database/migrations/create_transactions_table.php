<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('koverae-billing.tables.transations'), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->uuid('uuid')->unique();
            $table->foreignId('subscription_id')->constrained('plan_subscriptions')->onDelete('cascade');
            $table->string('payment_method')->nullable();
            $table->string('currency', 3);
            $table->decimal('amount', 10, 2);
            $table->decimal('fee', 10, 2)->default(0);
            $table->string('status')->default('pending'); // pending, completed, failed, refunded
            $table->json('metadata')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
