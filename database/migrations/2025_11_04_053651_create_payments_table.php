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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('status', ['pending', 'processing', 'succeeded', 'failed', 'refunded', 'partially_refunded'])->default('pending');
            $table->enum('payment_method', ['card', 'bank_transfer', 'cash', 'other'])->default('card');
            $table->string('stripe_payment_intent_id')->nullable()->unique();
            $table->string('stripe_refund_id')->nullable();
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->text('metadata')->nullable(); // JSON field for additional payment data
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index('booking_id');
            $table->index('status');
            $table->index('stripe_payment_intent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
