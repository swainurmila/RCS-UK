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
            $table->dropColumn('distance_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feasibility_reports', function (Blueprint $table) {
            $table->string('distance_unit');
        });
    }
};
