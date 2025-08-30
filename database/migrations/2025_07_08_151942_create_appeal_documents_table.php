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
        Schema::create('appeal_documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('appeal_id')->nullable();
            $table->bigInteger('asking_id')->nullable();
            $table->string('ask_to')->nullable();
            $table->string('requested_for')->nullable();
            $table->string('document_one')->nullable();
            $table->string('document_two')->nullable();
            $table->enum('status',[0,1])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appeal_documents');
    }
};
