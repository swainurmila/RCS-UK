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
        Schema::table('users', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('mob_no')->nullable();
            $table->string('society_name')->nullable();
            $table->string('member_type')->nullable();
            $table->integer('age')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('mob_no');
            $table->dropColumn('society_name');
            $table->dropColumn('member_type');
            $table->dropColumn('age');
            $table->dropColumn('role_id');
            $table->dropColumn('is_active');
            $table->dropColumn('verified_by');
            $table->dropColumn('verified_at');
            $table->dropColumn('token');
        });
    }
};
