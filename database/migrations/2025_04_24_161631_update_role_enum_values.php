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
        Schema::table('society_app_details', function (Blueprint $table) {
            $table->enum('current_role', ['arcs', 'ado', 'drcs', 'registrar'])->nullable()->change();
            $table->enum('submitted_to_role', ['arcs', 'ado', 'drcs', 'registrar'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('society_app_details', function (Blueprint $table) {
            $table->enum('current_role', ['ARCS', 'ADO', 'DRCS', 'Registrar'])->nullable()->change();
            $table->enum('submitted_to_role', ['ARCS', 'ADO', 'DRCS', 'Registrar'])->nullable()->change();
        });
    }
};
