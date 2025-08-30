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
        Schema::create('audit_ca_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('audit_id');
            $table->string('auditor_certificate_opinion');
            $table->string('audit_type')->comment("1-General Audit,2-special audit");
            $table->string('remark')->nullable();
            $table->string('signature');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_ca_reports');
    }
};
