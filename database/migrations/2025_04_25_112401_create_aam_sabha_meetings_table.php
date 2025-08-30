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
        Schema::create('aam_sabha_meetings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('society_id');

            $table->boolean('noticeOfAamSabha')->default(false);  

            $table->string('communication_method')->nullable();
            $table->string('other_communication')->nullable();  
            $table->date('ag_meeting_date')->nullable();
            $table->string('meeting_notice')->nullable();  // PDF file upload
            $table->timestamps();
            // $table->foreign('society_id')->references('id')->on('amendment_societies')->onDelete('cascade');
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aam_sabha_meetings');
    }
};
