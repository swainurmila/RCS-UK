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
        Schema::table('amendment_societies', function (Blueprint $table) {
            $table->string("amendment_ref_no")->nullable()->after('id');
            $table->enum('submitted_to_role', ['ARCS', 'ADO', 'DRCS', 'Registrar'])->after('block_id')->nullable()->after('quorum_members');
            $table->unsignedBigInteger('submitted_to_user_id')->after('submitted_to_role')->nullable()->after('submitted_to_role');
            $table->foreign('submitted_to_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('status')->comment("1-pending,2-Reverted,3-Approved by admin,4-Approved by JRCS")->nullable()->after('submitted_to_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amendment_societies', function (Blueprint $table) {
            //
        });
    }
};


