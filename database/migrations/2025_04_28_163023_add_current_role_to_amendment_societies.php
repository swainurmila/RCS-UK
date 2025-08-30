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
        Schema::table('amendment_societies', function (Blueprint $table) {
            $table->string('current_role')->nullable()->after('status');
            $table->unsignedBigInteger('user_id')->after('amendment_ref_no')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amendment_societies', function (Blueprint $table) {
            $table->dropColumn('current_role');
            $table->dropColumn('user_id');
        });
    }
};
