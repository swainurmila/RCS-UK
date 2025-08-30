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
        Schema::create('amendment_resolution_details_types', function (Blueprint $table) {
            $table->id(); // Optional primary key, remove if not needed
            $table->integer('SMId')->nullable();
            $table->string('FilePath', 250)->nullable();
            $table->dateTime('CreatedDate')->nullable();
            $table->string('CreatedBy', 100)->nullable();
            $table->dateTime('ModifiedDate')->nullable();
            $table->string('ModifiedBy', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amendment_resolution_details_types');
    }
};
