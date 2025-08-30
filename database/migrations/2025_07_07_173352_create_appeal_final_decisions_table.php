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
        Schema::create('appeal_final_decisions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('appeal_id')->nullable();
            $table->longText('remarks')->nullable();
            $table->string('docs')->nullable();
            $table->string('final_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appeal_final_decisions');
    }
};
