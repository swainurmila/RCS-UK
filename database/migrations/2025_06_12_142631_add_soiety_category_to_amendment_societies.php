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
              $table->integer('society_category')->nullable()->after('quorum_members')->comment("1-primary,2-central,3-apex");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amendment_societies', function (Blueprint $table) {
            $table->dropColumn('society_category');
        });
    }
};
