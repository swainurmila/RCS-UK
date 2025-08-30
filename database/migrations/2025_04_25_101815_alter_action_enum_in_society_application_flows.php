<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE society_application_flows 
        MODIFY COLUMN action ENUM('send', 'approve', 'reject', 'revert', 'verification', 'recheck') 
        NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE society_application_flows 
        MODIFY COLUMN action ENUM('send', 'approve', 'reject', 'revert', 'verification') 
        NOT NULL");
    }
};
