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
        Schema::table('society_app_details', function (Blueprint $table) {
           $table->boolean('documents_verified')->default(false);
        $table->foreignId('documents_verified_by')->nullable()->constrained('users');
        $table->timestamp('documents_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('society_app_details', function (Blueprint $table) {
            $table->dropColumn('documents_verified');
             $table->dropColumn('documents_verified_by');
              $table->dropColumn('documents_verified_at');

        });
    }
};
