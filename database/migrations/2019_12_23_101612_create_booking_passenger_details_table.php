<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingPassengerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_passenger_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('booking_id')->index();
            $table->string('name');
            $table->string('nationality');
            $table->string('gender');
            $table->string('passport');
            $table->string('expiry_date');
            $table->string('birth_date');
            $table->string('phone_number');
            $table->string('email');
            $table->string('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_passenger_details');
    }
}
