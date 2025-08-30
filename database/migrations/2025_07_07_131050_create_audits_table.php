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
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->string('audit_ref_no');
            $table->string('ca_firm_name');
            $table->string('ca_firm_reg_no');
            $table->string('ca_name');
            $table->string('ca_membership_no');
            $table->string('audit_period')->comment("financial year");
            $table->string('ca_email');
            $table->string('ca_address');
            $table->string('ca_mobile_no');
            $table->string('ca_website')->nullable();
            $table->integer('audit_for')->nullable()->comment("1-Bank,2-Society");
            $table->string('status')->comment("1-Pending,2-Approved by GM,3-Approved by ARCS");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
