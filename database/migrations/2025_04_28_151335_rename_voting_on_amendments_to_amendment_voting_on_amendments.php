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
        Schema::rename('voting_on_amendments', 'amendment_voting_on_amendments');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('amendment_voting_on_amendments', 'voting_on_amendments');
    }
};
