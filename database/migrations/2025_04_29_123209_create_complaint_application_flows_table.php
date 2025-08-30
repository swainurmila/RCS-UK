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
        Schema::create('complaint_application_flows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complaint_id');
            $table->string('from_role');
            $table->unsignedBigInteger('from_user_id')->nullable();
            $table->string('to_role')->nullable();
            $table->unsignedBigInteger('to_user_id')->nullable();
            $table->enum('direction', ['forward', 'reverse'])->default('forward');
            $table->enum('action', ['send', 'approve', 'reject', 'revert', 'verification', 'recheck']);
            $table->text('remarks')->nullable();
            $table->json('attachments')->nullable();
            $table->boolean('is_action_taken')->default(true);
            $table->unsignedBigInteger('acted_by')->nullable()->comment("action can only taken by");
            $table->timestamps();

            $table->foreign('acted_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('complaint_id')->references('id')->on('complaints')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_application_flows');
    }
};
