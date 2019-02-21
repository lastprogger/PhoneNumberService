<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'reservations', function (Blueprint $table) {

            $table->uuid('id');
            $table->string('type');
            $table->uuid('did_phone_number_id');
            $table->uuid('company_id');
            $table->boolean('active');
            $table->timestamp('created_at');
            $table->timestamp('reserved_until');
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
        Schema::drop('reservations');
    }
}
