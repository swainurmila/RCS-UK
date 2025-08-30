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
        Schema::create('appeal_approvals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('appeal_id')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('respondent_phone')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appeal_approvals');
    }
};
