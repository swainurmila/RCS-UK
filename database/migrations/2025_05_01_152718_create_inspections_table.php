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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->string('financial_year')->nullable();
            $table->integer('inspection_month')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('block_id')->nullable();
            $table->integer('society_type')->nullable();
            $table->integer('society_id')->nullable();
            $table->string('upload_inspection')->nullable();
            $table->enum('submitted_to_role', ['ARCS', 'ADO', 'DRCS', 'Registrar']);
            $table->integer('submitted_to_user_id');
            $table->enum('current_role', ['ARCS', 'ADO', 'DRCS', 'Registrar']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
