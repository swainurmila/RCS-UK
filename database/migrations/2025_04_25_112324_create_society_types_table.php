<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('society_type', function (Blueprint $table) {
            $table->id(); 
            $table->string('type', 100); 
            $table->tinyInteger('status')->default(1); 
            $table->timestamps(); 
        });



    }

    public function down(): void
    {
        Schema::dropIfExists('society_type');
    }
};