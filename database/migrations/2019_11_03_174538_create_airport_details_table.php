<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airport_details', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('city_name')->nullable();
            $table->string('airport_code')->nullable(); 
            $table->string('airport_name')->nullable();
            $table->string('country_name')->nullable();
            $table->string('country_abbrev')->nullable();
            $table->string('country_code')->nullable();
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
        Schema::dropIfExists('airport_details');
    }
}
