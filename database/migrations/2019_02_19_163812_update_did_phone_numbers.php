<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDidPhoneNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('did_phone_numbers', function (Blueprint $table) {

            $table->dropColumn(['company_id', 'pbx_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('did_phone_numbers', function (Blueprint $table) {

            $table->uuid('company_id');
            $table->uuid('pbx_id');
        });
    }
}
