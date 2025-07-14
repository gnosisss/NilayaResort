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
        Schema::create('checkout_transaction_details', function (Blueprint $table) {
            $table->id('detail_id');
            $table->foreignId('transaction_id')->constrained('checkout_transactions', 'transaction_id');
            $table->foreignId('unit_id')->constrained('rental_units', 'unit_id');
            $table->integer('nights');
            $table->float('price_per_night');
            $table->float('subtotal');
            $table->float('total');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_transaction_details');
    }
};