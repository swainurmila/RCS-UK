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
        Schema::create('settlement_evidence_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('settlement_id')->nullable();
            $table->string('amount_paid')->nullable();
            $table->string('challan_no')->nullable();
            $table->string('upload_challan_reciept')->nullable();
            $table->string('upload_documentary_evidence')->nullable();
            $table->string('upload_witness')->nullable();
            $table->string('upload_any_other_supporting')->nullable();
            $table->timestamps();
            $table->SoftDeletes();

            $table->foreign('settlement_id')->references('id')->on('settlement_application_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settlement_evidence_details');
    }
};