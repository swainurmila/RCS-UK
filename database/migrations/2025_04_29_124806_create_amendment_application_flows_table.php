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
        Schema::create('amendment_application_flows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('amendment_id');
            $table->string('from_role');
            $table->unsignedBigInteger('from_user_id')->nullable();
            $table->string('to_role')->nullable();
            $table->unsignedBigInteger('to_user_id')->nullable();
            $table->enum('direction', ['forward', 'reverse'])->default('forward');
            $table->enum('action', ['send', 'approve', 'reject', 'revert', 'verification', 'recheck']);
            $table->text('remarks')->nullable();
            $table->json('attachments')->nullable();
            $table->boolean('is_action_taken')->default(true);
            $table->unsignedBigInteger('acted_by')->comment("action can only be taken by");
            $table->timestamps();
            $table->foreign('acted_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('amendment_id')->references('id')->on('amendment_societies')->onDelete('cascade');
        });
      
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amendment_application_flows');
    }
};
