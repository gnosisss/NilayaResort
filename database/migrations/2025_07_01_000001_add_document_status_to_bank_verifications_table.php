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
        Schema::table('bank_verifications', function (Blueprint $table) {
            $table->string('document_status')->default('pending')->after('verification_notes');
            $table->text('revision_notes')->nullable()->after('document_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_verifications', function (Blueprint $table) {
            $table->dropColumn('document_status');
            $table->dropColumn('revision_notes');
        });
    }
};