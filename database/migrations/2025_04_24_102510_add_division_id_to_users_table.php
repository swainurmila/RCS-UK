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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('division_id')->nullable()->after('remember_token');
            $table->integer('district_id')->nullable()->after('division_id');
            $table->integer('block_id')->nullable()->after('district_id');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('division_id');
            $table->dropColumn('district_id');
            $table->dropColumn('block_id');
        });
    }
};