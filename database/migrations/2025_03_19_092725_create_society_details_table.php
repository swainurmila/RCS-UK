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
        Schema::create('society_details', function (Blueprint $table) {
            $table->id();
            $table->integer('auth_id');
            $table->bigInteger('scheme_id');
            $table->string('society_name')->nullable();
            $table->string('locality')->nullable();
            $table->string('post_office')->nullable();
            $table->string('developement_area')->nullable();
            $table->string('tehsil')->nullable();
            $table->string('district')->nullable();
            $table->string('nearest_station')->nullable();
            $table->date('applied_on')->nullable();
            $table->integer('society_category')->nullable()->comment("1-primary,2-central or apex,3-agricultural");
            $table->timestamps();

            // $table->foreign('scheme_id') // Foreign key for 'scheme_id'
            // ->references('id')    // Reference the 'id' field in the 'scheme' table
            // ->on('scheme')         // The table to reference (scheme)
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
