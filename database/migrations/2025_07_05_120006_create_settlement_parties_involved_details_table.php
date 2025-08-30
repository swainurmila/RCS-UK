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
        Schema::create('settlement_parties_involved_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('settlement_id')->nullable();
            $table->string('name1')->nullable();
            $table->text('address1')->nullable();
            $table->string('name2')->nullable();
            $table->text('address2')->nullable();
            $table->string('name3')->nullable();
            $table->text('address3')->nullable();
            $table->string('dname1')->nullable();
            $table->text('daddress1')->nullable();
            $table->string('dname2')->nullable();
            $table->text('daddress2')->nullable();
            $table->string('dname3')->nullable();
            $table->text('daddress3')->nullable();
            $table->timestamps();
            $table->SoftDeletes();

            $table->foreign('settlement_id')->references('id')->on('settlement_application_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settlement_parties_involved_details');
    }
};