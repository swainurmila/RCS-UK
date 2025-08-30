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
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('is_declared');
            $table->dropColumn('society_id');
            // $table->integer('member_type_id ')->nullable()->change();
            $table->boolean('is_married')->default(0)->change();
            $table->boolean('is_buisness')->default(0)->change();
            $table->integer('category')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // $table->integer('member_type_id ')->nullable(false)->change();
            $table->string('is_married ')->change();
            $table->string('is_buisness ')->change();
            $table->integer('category')->nullable(false)->change();
        });
    }
};
