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
        Schema::table('availabilities', function (Blueprint $table) {
            if (!Schema::hasColumn('availabilities', 'status')) {
                $table->string('status')->default('available')->after('available_date');
            }
            if (!Schema::hasColumn('availabilities', 'price')) {
                $table->decimal('price', 12, 2)->nullable()->after('status');
            }
            if (!Schema::hasColumn('availabilities', 'notes')) {
                $table->text('notes')->nullable()->after('price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
            $table->dropColumn(['status', 'price', 'notes']);
        });
    }
};