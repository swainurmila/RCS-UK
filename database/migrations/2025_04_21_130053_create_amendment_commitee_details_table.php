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
        Schema::create('amendment_commitee_details', function (Blueprint $table) {
            $table->id(); // Optional: if you want a primary key
            $table->integer('SMId')->nullable();
            $table->integer('SocityAddMemberId')->nullable();
            $table->boolean('IsVotedMember')->nullable();
            $table->dateTime('CreatedDate')->nullable();
            $table->string('CreatedBy', 100)->nullable();
            $table->dateTime('ModifiedDate')->nullable();
            $table->string('ModifiedBy', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amendment_commitee_details');
    }
};
