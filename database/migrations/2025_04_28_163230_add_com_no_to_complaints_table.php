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
        Schema::table('complaints', function (Blueprint $table) {
            $table->string("com_no")->after('id')->nullable();
            $table->unsignedBigInteger('user_id')->after('com_no')->nullable();
            $table->enum('submitted_to_role', ['arcs', 'ado', 'drcs', 'registrar'])->after('society')->nullable();
            $table->unsignedBigInteger('submitted_to_user_id')->after('submitted_to_role')->nullable();
            $table->enum('current_role', ['arcs', 'ado', 'drcs', 'registrar'])->after('submitted_to_user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('submitted_to_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['submitted_to_user_id']);
            $table->dropColumn('com_no');
            $table->dropColumn('user_id');
            $table->dropColumn('submitted_to_role');
            $table->dropColumn('submitted_to_user_id');
            $table->dropColumn('current_role');
        });
    }
};
