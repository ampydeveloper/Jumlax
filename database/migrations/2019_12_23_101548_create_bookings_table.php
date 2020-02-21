<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->index();
            $table->string('booking_reference');
            $table->string('from');
            $table->string('to');
            $table->text('segment');
            $table->text('price');
            $table->string('payment_method');
            $table->string('name');
            $table->string('nationality');
            $table->string('gender');
            $table->string('passport');
            $table->string('expiry_date');
            $table->string('birth_date');
            $table->string('phone_number');
            $table->string('email');
            $table->string('address');
            $table->string('reference_passenger_name');
            $table->string('reference');
            $table->string('reference_gender');
            $table->string('ticket_path')->nullable();
            $table->string('terms_agree');
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
        Schema::dropIfExists('bookings');
    }
}
