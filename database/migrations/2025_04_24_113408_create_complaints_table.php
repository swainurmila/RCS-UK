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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('complaint_name', 100)->nullable();
            $table->string('complaint_title', 60)->nullable();
            $table->string('contact_number', 13)->nullable();
            $table->string('email', 100)->nullable();
            $table->tinyInteger('complaint_type')->comment("1=>Aggressive,2=>Expressive,3=>Passive,4=>Constructive")->nullable();
            $table->tinyInteger('priority')->comment("1=>High,2=>Medium,3=>Low")->nullable();
            $table->string('attachment')->nullable();
            $table->integer('division')->nullable();
            $table->integer('district')->nullable();
            $table->integer('sub_division')->nullable();
            $table->integer('block')->nullable();
            $table->integer('society')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('status')->comment("1=>Active,0=>Inactive")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};