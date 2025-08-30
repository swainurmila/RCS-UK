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
        Schema::create('inspection_application_flow_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inspection_id')->nullable();
            $table->string('action_type')->nullable();  // e.g., 'status_change', 'rejection', 'approval'
            $table->string('old_value')->nullable()->nullable();  // e.g., old status, old value of any field
            $table->string('new_value')->nullable();  // e.g., new status, new value of any field
            $table->string('performed_by_role')->nullable();
            $table->unsignedBigInteger('performed_by_user')->nullable();
            $table->text('remarks')->nullable()->nullable();
            $table->timestamps();

            $table->foreign('inspection_id')->references('id')->on('inspections')->onDelete('cascade');
            $table->foreign('performed_by_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_application_flow_logs');
    }
};