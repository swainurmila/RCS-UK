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
             $table->enum('is_credit_society', ['0', '1'])->comment('1 => yes, 0 => no')->nullable()->after('scheme_id'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('society_details', function (Blueprint $table) {
             $table->dropColumn('is_credit_society');
        });
    }
};
