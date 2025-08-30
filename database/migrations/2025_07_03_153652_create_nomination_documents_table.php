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
        Schema::create('nomination_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nomination_id')->nullable();
            $table->boolean('is_new_society')->default(false);
            $table->date('formation_date')->nullable();
            $table->date('last_election_date')->nullable();
            $table->string('election_certificate')->nullable();
            $table->string('balance_sheet')->nullable();
            $table->string('audit_report')->nullable();
            $table->string('proposal')->nullable();
            $table->string('members_list')->nullable();
            $table->string('ward_allocation')->nullable();
            $table->string('challan_receipt')->nullable();
            $table->string('secretary_name');
            $table->string('secretary_signature')->nullable();
            $table->string('chairman_name');
            $table->string('chairman_signature')->nullable();
              $table->foreign('nomination_id')->references('id')->on('nominations')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomination_documents');
    }
};
