<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
            // Rename available_date to start_date
            if (Schema::hasColumn('availabilities', 'available_date') && !Schema::hasColumn('availabilities', 'start_date')) {
                $table->renameColumn('available_date', 'start_date');
            }
            
            // Add end_date column after start_date
            if (!Schema::hasColumn('availabilities', 'end_date')) {
                $table->date('end_date')->after('start_date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
            // Remove end_date column
            if (Schema::hasColumn('availabilities', 'end_date')) {
                $table->dropColumn('end_date');
            }
            
            // Rename start_date back to available_date
            if (Schema::hasColumn('availabilities', 'start_date') && !Schema::hasColumn('availabilities', 'available_date')) {
                $table->renameColumn('start_date', 'available_date');
            }
        });
    }
};