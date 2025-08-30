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
        DB::statement("ALTER TABLE appeals MODIFY COLUMN status ENUM('Pending', 'Approved', 'Rejected', 'Hiring', 'Final Decision Made', 'Awaiting Documents') DEFAULT 'Pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE appeals MODIFY COLUMN status ENUM('Pending', 'Approved', 'Rejected', 'Hiring', 'Final Decision Made') DEFAULT 'Pending'");
    }
};
