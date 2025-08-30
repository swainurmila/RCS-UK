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
        Schema::table('nominations', function (Blueprint $table) {
            $table->date('new_election_date')->nullable()->after('status');
            $table->string('election_status')->nullable()->after('new_election_date');
            $table->string('administrator_name')->nullable()->after('election_status');
            $table->string('administrator_designation')->nullable()->after('administrator_name');
            $table->string('administrator_area')->nullable()->after('administrator_designation');
            $table->date('administrator_join_date')->nullable()->after('administrator_area');
            $table->integer('administrator_days_of_working')->nullable()->after('administrator_join_date');
            $table->string('election_completion_certificate')->nullable()->after('administrator_days_of_working');
            $table->boolean('election_completed')->default(false)->after('election_completion_certificate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nominations', function (Blueprint $table) {
             $table->dropColumn([
                'new_election_date', 'election_status', 'administrator_name',
                'administrator_designation', 'administrator_area', 'administrator_join_date',
                'administrator_days_of_working', 'election_completion_certificate', 'election_completed'
            ]);
        });
    }
};
