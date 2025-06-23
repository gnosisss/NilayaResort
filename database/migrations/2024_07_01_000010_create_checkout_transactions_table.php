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
        Schema::create('checkout_transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->foreignId('booking_id')->constrained('bookings', 'booking_id');
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->string('transaction_code')->unique();
            $table->float('total_amount');
            $table->string('payment_status')->default('pending'); // pending, paid, failed, refunded
            $table->string('payment_method')->nullable();
            $table->timestamp('checkout_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_transactions');
    }
};