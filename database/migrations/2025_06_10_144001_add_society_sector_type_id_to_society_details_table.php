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
        Schema::table('society_details', function (Blueprint $table) {
            $table->unsignedBigInteger('society_sector_type_id')->nullable()->after('society_category');
            $table->foreign('society_sector_type_id')->references('id')->on('society_sector_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('society_details', function (Blueprint $table) {
            $table->dropForeign(['society_sector_type_id']);
            $table->dropColumn('society_sector_type_id');
        });
    }
};
