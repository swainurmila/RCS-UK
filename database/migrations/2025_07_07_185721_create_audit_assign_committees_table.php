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
        Schema::create('audit_assign_committees', function (Blueprint $table) {
            $table->id();
            $table->integer("audit_id");
            $table->integer("designation");
            $table->integer("member_id");
            $table->integer("district_id");
            $table->integer("block_id");
            $table->integer("current_role");
            $table->integer("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_assign_committees');
    }
};
