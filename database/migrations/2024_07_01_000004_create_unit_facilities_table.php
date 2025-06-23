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
        Schema::create('unit_facilities', function (Blueprint $table) {
            $table->id('unit_facility_id');
            $table->foreignId('unit_id')->constrained('rental_units', 'unit_id');
            $table->foreignId('facility_id')->constrained('facilities', 'facility_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_facilities');
    }
};