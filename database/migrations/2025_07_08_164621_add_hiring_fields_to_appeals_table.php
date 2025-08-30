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
        Schema::table('appeals', function (Blueprint $table) {
            $table->date('hiring_date')->nullable()->after('status');
            $table->longText('hiring_remark')->nullable()->after('hiring_date');
            $table->BigInteger('hiring_assigned_by')->nullable()->after('hiring_remark');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appeals', function (Blueprint $table) {
            $table->dropColumn([
                'hiring_date',
                'hiring_remark',
                'hiring_assigned_by'
            ]);
        });
    }
};
