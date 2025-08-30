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
        Schema::rename('managing_committes', 'amendment_managing_committes');
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('amendment_managing_committes', 'managing_committes');
    }
};
