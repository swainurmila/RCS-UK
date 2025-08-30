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
            $table->string("membership_form")->after('end_date')->nullable(); 
            $table->string("declaration1")->after('membership_form')->nullable();    
            $table->string("declaration2")->after('declaration1')->nullable();    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('membership_form');
            $table->dropColumn('declaration1');
            $table->dropColumn('declaration2');
        });
    }
};
