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
        Schema::create('settlement_application_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('applicant_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mobile_number', 10)->nullable();
            $table->string('email')->nullable();
            $table->text('full_address')->nullable();
            $table->enum('submitted_to_role', ['arcs', 'ado', 'adco', 'drcs', 'registrar', 'jrcs', 'additionalrcs'])->nullable();
            $table->unsignedBigInteger('submitted_to_user_id')->nullable();
            $table->enum('current_role', ['arcs', 'ado', 'drcs', 'adco', 'registrar', 'jrcs', 'additionalrcs'])->nullable();
            $table->string('status')->nullable()->default('1');
            $table->timestamps();
            $table->SoftDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('submitted_to_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settlement_application_details');
    }
};