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
        Schema::create('society_register_documents', function (Blueprint $table) {
            $table->id();
            $table->integer("society_id")->nullable();
            $table->string("meeting1")->nullable();
            $table->string("meeting2")->nullable();
            $table->string("meeting3")->nullable();
            $table->string("all_id_proof")->nullable();
            $table->string("all_application_form")->nullable();
            $table->string("all_declaration_form")->nullable();
            $table->string("society_by_laws")->nullable();
            $table->string("challan_proof")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('society_register_documents');
    }
};
