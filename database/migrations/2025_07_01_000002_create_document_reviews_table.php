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
        Schema::create('document_reviews', function (Blueprint $table) {
            $table->id('review_id');
            $table->unsignedBigInteger('verification_id');
            $table->unsignedBigInteger('document_id')->nullable();
            $table->string('document_type');
            $table->enum('status', ['accepted', 'revision', 'rejected'])->default('accepted');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('verification_id')
                  ->references('verification_id')
                  ->on('bank_verifications')
                  ->onDelete('cascade');
                  
            $table->foreign('document_id')
                  ->references('document_id')
                  ->on('property_documents')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_reviews');
    }
};