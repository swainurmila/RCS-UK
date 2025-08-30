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
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->string('role', 11)->nullable();
            $table->integer('user_id')->nullable();
            $table->string('msg_id')->nullable();
            $table->integer('otp')->nullable();
            $table->enum('status', ['0', '1', '2'])->default('0');
            $table->string('error_code')->nullable();
            $table->dateTime('otp_ex_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
