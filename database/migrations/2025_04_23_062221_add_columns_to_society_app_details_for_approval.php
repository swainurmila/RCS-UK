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
            $table->unsignedBigInteger('user_id')->after('app_no')->nullable();
            $table->float('app_progress')->nullable();
            $table->date('cutoff_date')->nullable();
            $table->enum('current_role', ['ARCS', 'ADO', 'DRCS', 'Registrar'])->nullable();
            $table->unsignedBigInteger('division_id')->after('user_id')->nullable();
            $table->unsignedBigInteger('district_id')->after('division_id')->nullable();
            $table->unsignedBigInteger('block_id')->after('district_id')->nullable();
            $table->enum('submitted_to_role', ['ARCS', 'ADO', 'DRCS', 'Registrar'])->after('block_id')->nullable();
            $table->unsignedBigInteger('submitted_to_user_id')->after('submitted_to_role')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
            $table->foreign('submitted_to_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('society_app_details', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['division_id']);
            $table->dropForeign(['district_id']);
            $table->dropForeign(['block_id']);
            $table->dropForeign(['submitted_to_user_id']);

            $table->dropColumn([
                'user_id',
                'app_progress',
                'cutoff_date',
                'current_role',
                'division_id',
                'district_id',
                'block_id',
                'submitted_to_role',
                'submitted_to_user_id',
            ]);
        });
    }
};
