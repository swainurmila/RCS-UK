<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('society_app_details', function (Blueprint $table) {
        $table->dropColumn('is_credit_society');
    });
}

public function down()
{
    Schema::table('society_app_details', function (Blueprint $table) {
        $table->enum('is_credit_society', ['0', '1'])->nullable()->comment('1 => yes, 0 => no')->after('scheme_id');
    });
}
};
