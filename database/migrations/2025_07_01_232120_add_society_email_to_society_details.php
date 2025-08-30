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
            $table->string('society_email')->nullable()->after('society_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('society_details', function (Blueprint $table) {
            $table->dropColumn('society_email');
        });
    }
};
