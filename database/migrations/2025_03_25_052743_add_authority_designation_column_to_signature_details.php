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
        Schema::table('signature_details', function (Blueprint $table) {
            $table->string('authority_designation')->nullable();
            $table->string('authority_name')->nullable();
            $table->renameColumn('feasibility_report_id', 'society_id');
            $table->renameColumn('registered_person_signature', 'authority_signature');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('signature_details', function (Blueprint $table) {
            $table->dropColumn('authority_designation');
            $table->dropColumn('authority_name');
            $table->renameColumn('society_id', 'feasibility_report_id');
            $table->renameColumn('authority_signature', 'registered_person_signature');
        });
    }
};
