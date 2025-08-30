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
        Schema::table('feasibility_reports', function (Blueprint $table) {
           $table->string("area_operation")->after('existing_society_details')->nullable();
           $table->string("authority_name")->after('area_operation')->nullable();
           $table->string("authority_designation")->after('authority_name')->nullable();
           $table->string("authority_signature")->after('authority_designation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feasibility_reports', function (Blueprint $table) {
            $table->dropColumn('area_operation');
            $table->dropColumn('authority_name');
            $table->dropColumn('authority_designation');
            $table->dropColumn('authority_signature');
        });
    }
};
