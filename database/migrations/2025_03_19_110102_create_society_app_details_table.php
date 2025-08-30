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
        Schema::create('society_app_details', function (Blueprint $table) {
            $table->id();
            $table->string("app_id");
            $table->string("app_no");
            $table->integer("app_count");
            $table->integer("app_phase");
            $table->integer("scheme_id");
            $table->integer('status')->comment("1-pending,2-Reverted,3-Approved by admin,4-Approved by JRCS");
            $table->timestamps();

            // $table->foreign('scheme_id') // Foreign key for 'scheme_id'
            // ->references('id')    // Reference the 'id' field in the 'scheme' table
            // ->on('schema')         // The table to reference (scheme)
            // ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('society_details');
    }
};
