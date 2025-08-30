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
        Schema::table('society_register_documents', function (Blueprint $table) {
            $docFields = [
                'meeting1',
                'meeting2',
                'meeting3',
                'society_by_laws',
                'all_id_proof',
                'all_application_form',
                'all_declaration_form',
                'challan_proof'
            ];

            foreach ($docFields as $field) {
                $table->string("{$field}_status")->default('pending')->after($field);
                $table->text("{$field}_remarks")->nullable()->after("{$field}_status");
                $table->string("{$field}_revised")->nullable()->after("{$field}_remarks");
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('society_register_documents', function (Blueprint $table) {
            $docFields = [
                'meeting1',
                'meeting2',
                'meeting3',
                'society_by_laws',
                'all_id_proof',
                'all_application_form',
                'all_declaration_form',
                'challan_proof'
            ];
               foreach ($docFields as $field) {
                $table->dropColumn("{$field}_status");
                $table->dropColumn("{$field}_remarks");
                $table->dropColumn("{$field}_revised");
            }
        });
    }
};
