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
        Schema::create('rental_units', function (Blueprint $table) {
            $table->id('unit_id');
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->foreignId('category_id')->constrained('categories', 'category_id');
            $table->string('address');
            $table->string('type');
            $table->string('slug');
            $table->float('price_per_night');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_units');
    }
};