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
        Schema::table('complaints', function (Blueprint $table) {
            $table->unsignedBigInteger('complaint_by_society_id')->after('user_id')->nullable();
            $table->foreign('complaint_by_society_id')->references('id')->on('society_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropForeign(['complaint_by_society_id']);
            $table->dropColumn('complaint_by_society_id');
        });
    }
};