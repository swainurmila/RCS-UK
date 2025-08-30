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
        Schema::table('complaint_application_flows', function (Blueprint $table) {
            $table->string('signature')->after('attachments')->nullable();
            $table->integer('by_authorized_Person_id')->after('signature')->nullable();
            $table->string('forward_by_designation')->after('by_authorized_Person_id')->nullable();
            $table->string('forward_to_designation')->after('forward_by_designation')->nullable();
            $table->integer('forward_to_authorized_Person_id')->after('forward_to_designation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaint_application_flows', function (Blueprint $table) {
            $table->dropColumn('signature');
            $table->dropColumn('by_authorized_Person_id');
            $table->dropColumn('forward_by_designation');
            $table->dropColumn('forward_to_designation');
            $table->dropColumn('forward_to_authorized_Person_id');
        });
    }
};