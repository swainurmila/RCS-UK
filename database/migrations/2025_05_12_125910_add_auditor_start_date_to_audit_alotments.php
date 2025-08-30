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
        Schema::table('audit_alotments', function (Blueprint $table) {
            $table->date('audit_start_date_auditor')->nullable()->after('society_id');
            $table->date('audit_end_date_auditor')->nullable()->after('audit_start_date_auditor');
            $table->date('audit_start_date_society')->nullable()->after('audit_end_date_auditor');
            $table->date('audit_end_date_society')->nullable()->after('audit_start_date_society');
            $table->integer('status')->default(0)->after('audit_end_date_society');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audit_alotments', function (Blueprint $table) {
                  $table->dropColumn([
                'audit_start_date_auditor',
                'audit_end_date_auditor',
                'audit_start_date_society',
                'audit_end_date_society',
                'status'
            ]);
        });
    }
};
