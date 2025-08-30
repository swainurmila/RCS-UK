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
        Schema::create('document_verification_flows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('society_app_detail_id')->nullable();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->string('document_field')->nullable();
            $table->string('remarks')->nullable();    
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_verification_flows');
    }
};
