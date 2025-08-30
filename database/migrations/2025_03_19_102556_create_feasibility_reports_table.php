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
        Schema::create('feasibility_reports', function (Blueprint $table) {
            $table->id();
            $table->integer("member_declaration_id");
            $table->string("society_name")->nullable();
            $table->text("society_formation_reason")->nullable();
            $table->integer("society_type")->nullable()->comment("1-Village society,0-not a village society");
            $table->integer("society_based_on")->nullable()->comment("1-Mutual Interest,2-Co-operative Model");
            $table->string("bank_name");
            // $table->string("branch_name");
            $table->string("society_bank_distance")->nullable();
            $table->string("distance_unit");
            $table->integer("membership_limit");
            $table->integer("total_members_ready_to_join");
            $table->integer("is_member_active")->comment("1-yes,0-no");
            $table->string("chairman_name")->nullable();
            $table->string("secretary_name")->nullable();
            $table->integer("is_member_understood_rights")->nullable()->comment("1-yes,0-no");
            $table->integer("is_member_awared_objectives")->nullable()->comment("1-yes,0-no");
            $table->integer("is_existing_society")->nullable()->comment("1-yes,0-no");
            $table->text("existing_society_details")->nullable();
            $table->date("society_registration_date")->nullable();
            $table->string("society_completion_time")->nullable();
            $table->text("additional_info")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feasibility_reports');
    }
};
