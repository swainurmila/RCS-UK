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
        Schema::create('audit_bank_details', function (Blueprint $table) {
            $table->id();
            $table->string('audit_id');
            $table->string('bank_id');
            $table->string('district_id');
            $table->string('bank_address');
            $table->string('bank_head_office_address');
            $table->string('bank_letter_to_sbi');
            $table->string('balance_sheet');
            $table->string('profit_loss_statement');
            $table->string('lfar_annexture');
            $table->string('other_docs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_bank_details');
    }
};
