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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->integer("member_declaration_id"); //id of member_type table
            $table->integer("gender")->nullable()->comment("1-Male,2-Female,3-Transgender");
            $table->integer("category")->nullable()->comment("1-SC,2-ST,3-General");
            $table->string("is_married")->nullable()->comment("1-yes,0-no");
            $table->string("father_spouse_name")->nullable();
            $table->string("is_buisness")->nullable();
            $table->string("buisness_name")->nullable();
            $table->string("address")->nullable();
            $table->integer("business")->comment("1-private,2-public,3-Enterprise"); // Private,public,Enterprise
            $table->string("designation")->nullable();
            $table->string("signature")->nullable();
            $table->date("start_date")->nullable();
            $table->date("end_date")->nullable();
            $table->integer("is_declared")->comment("agree-1,not agree-0");
            $table->timestamps();

            // $table->foreign('member_declaration_id') // Foreign key for 'member_type_id'
            // ->references('id')    // Reference the 'id' field in the 'member_type' table
            // ->on('member_declarations')         // The table to reference (member_type)
            // ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
