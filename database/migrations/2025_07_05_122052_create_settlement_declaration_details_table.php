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
        Schema::create('settlement_declaration_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('settlement_id')->nullable();
            $table->boolean('is_confirmed')->nullable();
            $table->string('Upload_signature')->nullable();
            $table->boolean('is_individual')->nullable();
            $table->string('upload_resolution')->nullable();
            $table->string('aadhar_upload')->nullable();
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
        Schema::dropIfExists('settlement_declaration_details');
    }
};