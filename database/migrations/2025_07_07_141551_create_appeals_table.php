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
        Schema::create('appeals', function (Blueprint $table) {
            $table->id();
            $table->string('appeal_no')->nullable();
            $table->string('appeal_by')->nullable();
            $table->string('appellant_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('designation')->nullable();
            $table->string('district_id')->nullable();
            $table->string('aadhar')->nullable();
            $table->string('full_address')->nullable();
            $table->string('signature_of_appellant')->nullable();
            $table->string('typeoforder')->nullable();
            $table->string('orderno')->nullable();
            $table->string('subject')->nullable();
            $table->string('amtofchallan')->nullable();
            $table->string('order')->nullable();
            $table->string('evidence')->nullable();
            $table->string('challanreceipt')->nullable();
            $table->string('appeal_against')->nullable();
            $table->string('appeal_against_district_id')->nullable();
            $table->string('appeal_to')->nullable();
            $table->enum('status',['Pending','Approved','Rejected','Hiring','Final Decision Made'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appeals');
    }
};
