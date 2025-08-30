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
        Schema::create('inspection_targets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("dist_id")->nullable();
            $table->unsignedBigInteger("designation_id")->nullable();
            $table->unsignedBigInteger("assigned_officer_id")->nullable();
            $table->unsignedInteger("society_count")->nullable();
            $table->unsignedBigInteger("created_by")->nullable();
            $table->smallInteger("status")->nullable();
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_targets');
    }
};
