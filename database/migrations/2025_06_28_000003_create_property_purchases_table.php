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
        Schema::create('property_purchases', function (Blueprint $table) {
            $table->id('purchase_id');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('unit_id')->on('rental_units')->onDelete('cascade');
            $table->string('purchase_code')->unique();
            $table->decimal('purchase_amount', 15, 2);
            $table->string('status')->default('pending'); // pending, verified, approved, rejected
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_purchases');
    }
};