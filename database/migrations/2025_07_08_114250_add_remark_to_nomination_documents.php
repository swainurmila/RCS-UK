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
        Schema::table('nomination_documents', function (Blueprint $table) {
              $table->text('remark')->nullable()->after('chairman_signature');
            $table->string('remark_file')->nullable()->after('remark');
            $table->boolean('approved')->default(false)->after('remark_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nomination_documents', function (Blueprint $table) {
            $table->dropColumn(['remark','remark_file','approved']);
        });
    }
};
