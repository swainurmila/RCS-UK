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
        Schema::table('sub_divisions', function (Blueprint $table) {
            $table->string('name', 191)->after('id')->nullable();
            $table->integer('district_id')->after('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_divisions', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('district_id');
        });
    }
};
