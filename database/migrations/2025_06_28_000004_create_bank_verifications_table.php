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
        Schema::create('bank_verifications', function (Blueprint $table) {
            $table->id('verification_id');
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('purchase_id')->references('purchase_id')->on('property_purchases')->onDelete('cascade');
            $table->unsignedBigInteger('bank_user_id');
            $table->foreign('bank_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('documents_verified')->default(false);
            $table->boolean('credit_approved')->default(false);
            $table->decimal('credit_score', 5, 2)->nullable();
            $table->decimal('approved_amount', 15, 2)->nullable();
            $table->text('verification_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_verifications');
    }
};