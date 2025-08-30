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
        Schema::create('audit_alotments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fy_id'); 
            $table->unsignedBigInteger('dept_auditor_id'); 
            $table->unsignedBigInteger('society_type_id'); 
            $table->unsignedBigInteger('district_id'); 
            $table->unsignedBigInteger('block_id'); 
            $table->unsignedBigInteger('society_id'); 
            $table->timestamps();

            // $table->foreign('fy_id')->references('id')->on('financial_years')->onDelete('cascade');
            $table->foreign('dept_auditor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('society_type_id')->references('id')->on('society_type')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
            $table->foreign('society_id')->references('id')->on('society_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_alotments');
    }
};
