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
        Schema::create('inspection_application_flows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inspection_id');
            $table->string('from_role');
            $table->unsignedBigInteger('from_user_id')->nullable();
            $table->string('to_role')->nullable();
            $table->unsignedBigInteger('to_user_id')->nullable();
            $table->enum('direction', ['forward', 'reverse'])->default('forward');
            $table->enum('action', ['send', 'resolved', 'unresolved', 'revert', 'verification', 'recheck']);
            $table->text('remarks')->nullable();
            $table->json('attachments')->nullable();
            $table->boolean('is_action_taken')->default(true);
            $table->unsignedBigInteger('acted_by')->nullable()->comment("action can only taken by");
            $table->timestamps();

            $table->foreign('acted_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('inspection_id')->references('id')->on('inspections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_application_flows');
    }
};