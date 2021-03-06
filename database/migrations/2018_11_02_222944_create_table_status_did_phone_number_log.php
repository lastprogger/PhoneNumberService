<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStatusDidPhoneNumberLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'status_did_phone_number_logs', function (Blueprint $table) {

            $table->increments('id');
            $table->string('status');
            $table->uuid('did_phone_number_id');
            $table->uuid('company_id')->nullable();
            $table->string('comment')->nullable();
            $table->timestamp('created_at');
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('status_did_phone_number_logs');
    }
}
