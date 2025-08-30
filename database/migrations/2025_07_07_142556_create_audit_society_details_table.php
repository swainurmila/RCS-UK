<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audit_society_details', function (Blueprint $table) {
            $table->id();
            $table->string('audit_id');
            $table->string('society_id');
            $table->string('district');
            $table->string('block');
            $table->string('society_type');
            $table->string('society_chairman_name');
            $table->string('society_secretary_name');
            $table->string('balance_sheet');
            $table->string('profit_loss_statement');
            $table->string('other_docs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_society_details');
    }
};
