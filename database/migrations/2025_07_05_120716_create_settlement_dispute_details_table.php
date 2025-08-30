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
        Schema::create('settlement_dispute_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('settlement_id')->nullable();
            $table->text('against_the_defendant')->nullable();
            $table->text('plaintiff_seek_arbitration')->nullable();
            $table->text('cause_of_action_arose')->nullable();
            $table->text('valuation_case')->nullable();
            $table->string('valuation_case_amount')->nullable();
            $table->text('desired_relief')->nullable();
            $table->text('witnesses_and_documents')->nullable();
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
        Schema::dropIfExists('settlement_dispute_details');
    }
};