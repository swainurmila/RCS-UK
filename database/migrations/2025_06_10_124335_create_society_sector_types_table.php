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
        Schema::create('society_sector_types', function (Blueprint $table) {
            $table->id();
            $table->string("cooperative_sector_name")->nullable();
            $table->enum('is_active', ['0', '1'])->comment('0 => inactive, 1 => active')->default('1');
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('society_sector_types');
    }
};
