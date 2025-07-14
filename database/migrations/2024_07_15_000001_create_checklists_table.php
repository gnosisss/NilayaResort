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
        Schema::create('checklists', function (Blueprint $table) {
            $table->id('checklist_id');
            $table->string('item');
            $table->text('description')->nullable();
            $table->float('price')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Add the checklist_id column to checkout_transaction_details table if it doesn't exist
        if (!Schema::hasColumn('checkout_transaction_details', 'checklist_id')) {
            Schema::table('checkout_transaction_details', function (Blueprint $table) {
                $table->foreignId('checklist_id')->nullable()->after('unit_id')
                    ->constrained('checklists', 'checklist_id')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the foreign key constraint and column from checkout_transaction_details
        if (Schema::hasColumn('checkout_transaction_details', 'checklist_id')) {
            Schema::table('checkout_transaction_details', function (Blueprint $table) {
                $table->dropForeign(['checklist_id']);
                $table->dropColumn('checklist_id');
            });
        }
        
        Schema::dropIfExists('checklists');
    }
};