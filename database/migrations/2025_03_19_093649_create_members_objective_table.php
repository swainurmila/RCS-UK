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
        Schema::create('members_objective', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('society_id');
            $table->integer('member_responsibility_type')->nullable();
            $table->integer('capital_valuation_type')->nullable();
            $table->decimal('capital_amount',8, 2)->nullable();
            $table->string('society_operational_area')->nullable();
            $table->string('society_objective')->nullable();
            $table->string('society_share_value')->nullable();
            $table->string('member_liability')->nullable();
            $table->integer('general_member_count')->nullable();
            $table->integer('society_record_language')->nullable()->comment('1-English,2-Hindi');
            $table->string('society_representative_name')->nullable();
            $table->string('society_representative_address')->nullable();
            $table->string('society_representative_signature')->nullable();
            $table->string('society_secretary_name')->nullable();
            $table->string('society_secretary_address')->nullable();
            $table->string('society_secretary_signature')->nullable();
            // $table->string('society_address');
            $table->timestamps();

            // $table->foreign('society_id') // Foreign key for 'user_id'
            //       ->references('id')    // Reference the 'id' field in the 'users' table
            //       ->on('society_details')         // The table to reference (users)
            //       ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members_objective');
    }
};
