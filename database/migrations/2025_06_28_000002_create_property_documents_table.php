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
        Schema::create('property_documents', function (Blueprint $table) {
            $table->id('document_id');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('purchase_id')->references('purchase_id')->on('property_purchases')->onDelete('cascade');
            $table->string('document_type'); // KTP, KK, SLIP_GAJI, NPWP, etc.
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_extension');
            $table->string('file_size');
            $table->string('status')->default('pending'); // pending, verified, rejected
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_documents');
    }
};