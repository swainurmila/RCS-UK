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
        Schema::create('amendment_societies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('act')->nullable();
            $table->integer('total_members')->nullable();
            $table->string('address')->nullable();
            $table->string('area_of_operation')->nullable();
            $table->string('e18_certificate')->nullable();
            $table->integer('total_board_members')->nullable();
            $table->integer('quorum_members')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amendment_societies');
    }
};
