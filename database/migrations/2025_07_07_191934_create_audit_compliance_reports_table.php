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
        Schema::create('audit_compliance_reports', function (Blueprint $table) {
            $table->id();
            $table->integer("audit_id");
            $table->string("review_by_role");
            $table->integer("review_by_id");
            $table->integer("compliance_type")->comment("1-principal,2-deposited amount");
            $table->string("compliance_report");
            $table->decimal("compliance_amount");
            $table->string("evidence_report");
            $table->integer("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_compliance_reports');
    }
};
