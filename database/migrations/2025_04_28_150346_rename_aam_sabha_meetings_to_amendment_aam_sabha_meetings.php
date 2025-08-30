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
        Schema::rename('aam_sabha_meetings', 'amendment_aam_sabha_meetings');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('amendment_aam_sabha_meetings', 'aam_sabha_meetings');
    }
};
