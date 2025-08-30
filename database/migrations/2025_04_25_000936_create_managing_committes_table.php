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
        Schema::create('managing_committes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('society_id')->nullable();
            $table->string('existing_bylaw')->nullable();
            $table->string('bylaw_section')->nullable();
            $table->string('proposed_amendment')->nullable();
            $table->text('purpose_of_amendment')->nullable();
            $table->enum('approval', ['yes', 'no'])->default('no'); 
            $table->string('committee_approval_doc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managing_committes');
    }
};
