<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            // Step 1: Convert existing values to lowercase
            DB::statement("UPDATE inspections SET `submitted_to_role` = LOWER(`submitted_to_role`), `current_role` = LOWER(`current_role`)");

            // Step 2: Alter enum to accept only lowercase values
            DB::statement("ALTER TABLE inspections MODIFY `submitted_to_role` ENUM('arcs', 'ado', 'drcs', 'registrar') NOT NULL");
            DB::statement("ALTER TABLE inspections MODIFY `current_role` ENUM('arcs', 'ado', 'drcs', 'registrar') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            DB::statement("ALTER TABLE inspections MODIFY `submitted_to_role` ENUM('ARCS', 'ADO', 'DRCS', 'Registrar') NOT NULL");
            DB::statement("ALTER TABLE inspections MODIFY `current_role` ENUM('ARCS', 'ADO', 'DRCS', 'Registrar') NOT NULL");
        });
    }
};