<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDidPhoneNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'did_phone_numbers', function (Blueprint $table) {

            $table->uuid('id');
            $table->string('phone_number');
            $table->string('status');
            $table->uuid('company_id')->nullable();
            $table->uuid('pbx_id')->nullable();
            $table->string('friendly_phone_number');
            $table->string('country');
            $table->boolean('toll_free');
            $table->timestamps();
            $table->softDeletes();
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
        Schema::drop('did_phone_numbers');
    }
}
