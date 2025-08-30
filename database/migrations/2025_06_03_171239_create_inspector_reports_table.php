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
        Schema::create('inspector_reports', function (Blueprint $table) {
            $table->id();
            $table->integer("society_id")->nullable();
            $table->dateTime("permanent_inspection_date")->nullable();
            $table->tinyInteger("member_knowledge")->nullable();
            $table->tinyInteger("panchayat_suitability")->comment("1-yes,0-No")->nullable();
            $table->tinyInteger("family_wilingness")->comment("1-yes,0-No")->nullable();
            $table->string("family_wilingness_reason")->nullable();
            $table->tinyInteger("is_bank_capital_available")->comment("1-yes,0-No")->nullable();
            $table->string('authority_designation')->nullable();
            $table->string('authority_name')->nullable();
            $table->string('authority_signature')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspector_reports');
    }
};
