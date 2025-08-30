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
        Schema::create('nominations', function (Blueprint $table) {
            $table->id();
            $table->string('society_name');
            $table->integer('society_category')->nullable()->comment("1-primary,2-central,3-apex");
            $table->unsignedBigInteger('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->unsignedBigInteger('block_id')->nullable();
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
            $table->string('registration_number');
            $table->integer('total_members');
             $table->unsignedBigInteger('user_id')->nullable();
              $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
             $table->integer('status')->comment("1-pending,2-Reverted,3-Approved by admin,4-Approved by JRCS")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nominations');
    }
};
