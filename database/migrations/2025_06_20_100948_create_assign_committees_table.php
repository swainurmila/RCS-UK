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
        Schema::create('assign_committees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complaint_id');
            $table->string('designation')->nullable();
            $table->integer('member_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('block_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('current_role')->nullable();
            $table->tinyInteger('status')->comment("1=>Active,0=>Inactive")->default(1);
            $table->timestamps();
            $table->SoftDeletes();

            $table->foreign('complaint_id')->references('id')->on('complaints')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_committees');
    }
};