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
        Schema::create('voting_on_amendments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('society_id');
            $table->boolean('quorum_completed')->default(false); 
            $table->integer('total_members')->nullable();
            $table->integer('members_present')->nullable();
            $table->integer('votes_favor')->nullable();
            $table->integer('votes_against')->nullable();
            $table->integer('total_voted')->nullable();
            $table->integer('abstain_members')->nullable();
            $table->text('resolution_amendment')->nullable();
            $table->string('resolution_file')->nullable();
            // $table->foreign('society_id')->references('id')->on('amendment_societies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voting_on_amendments');
    }
};
