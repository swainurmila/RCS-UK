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
        Schema::table('inspections', function (Blueprint $table) {
            $table->unsignedBigInteger('assign_officer_id')->after('upload_inspection')->nullable();
            $table->string('remarks')->nullable()->after('current_role');
            $table->integer('status')->default('1')->nullable()->after('remarks');
            $table->foreign('assign_officer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            $table->dropForeign(['assign_officer_id']);
            $table->dropColumn('assign_officer_id');
            $table->dropColumn('remarks');
        });
    }
};