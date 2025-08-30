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
        Schema::create('inspection_target_societies', function (Blueprint $table) {
            $table->id();

            // Foreign keys (nullable for flexibility)
            $table->foreignId('inspection_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('block_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('society_id')->nullable()->constrained()->nullOnDelete();

            $table->smallInteger('inspection_status')->nullable();
            $table->text('inspection_remark')->nullable();
            $table->string('inspection_document')->nullable();
            $table->foreignId('inspection_designation_id')->nullable()->constrained('designations')->nullOnDelete();
            $table->foreignId('inspection_officer_id')->nullable()->constrained('users')->nullOnDelete(); // assuming officers are users
            $table->string('inspection_signature')->nullable();

            $table->text('final_remark')->nullable();
            $table->string('final_inspection_document')->nullable();
            $table->foreignId('final_designation_id')->nullable()->constrained('designations')->nullOnDelete();
            $table->foreignId('final_officer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('final_signature')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_target_societies');
    }
};
