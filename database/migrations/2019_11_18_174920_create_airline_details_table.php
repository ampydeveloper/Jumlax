<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirlineDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airline_details', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('al_code');
            $table->string('al_code_number');   
            $table->string('al_icao');   
            $table->string('al_name');   
            $table->string('al_country');   
            $table->string('image');   
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
        Schema::dropIfExists('airline_details');
    }
}
