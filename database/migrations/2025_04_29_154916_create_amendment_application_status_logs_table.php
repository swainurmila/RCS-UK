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
        Schema::create('amendment_application_status_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('amendment_id');
            $table->string('action_type');
            $table->string('old_value')->nullable();
            $table->string('new_value')->nullable();
            $table->string('performed_by_role')->nullable();
            $table->unsignedBigInteger('performed_by_user')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        
            $table->foreign('amendment_id')->references('id')->on('amendment_societies')->onDelete('cascade');
            $table->foreign('performed_by_user')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amendment_application_status_logs');
    }
};
