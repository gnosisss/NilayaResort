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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id('payment_id');
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('user_id');
            $table->string('payment_code', 50)->unique();
            $table->decimal('amount', 10, 2);
            $table->string('payment_method', 50);
            $table->string('payment_status', 20)->default('pending');
            $table->string('payment_proof')->nullable();
            $table->text('payment_notes')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();
            
            $table->foreign('transaction_id')
                  ->references('transaction_id')
                  ->on('checkout_transactions')
                  ->onDelete('cascade');
                  
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};