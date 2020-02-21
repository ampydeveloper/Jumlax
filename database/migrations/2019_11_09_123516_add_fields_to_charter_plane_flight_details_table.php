<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToCharterPlaneFlightDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('charter_plane_flight_details', function (Blueprint $table) {
            $table->unsignedBigInteger('plane_id')->after('id');;
            $table->foreign('plane_id')->references('id')->on('charter_planes');
            $table->dateTimeTz('departure_time')->after('plane_id')->nullable();
            $table->dateTimeTz('arriving_time')->after('departure_time')->nullable();
            $table->string('from')->after('arriving_time')->nullable();
            $table->string('to')->after('to')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('charter_plane_flight_details', function (Blueprint $table) {
            $table->dropColumn('from');
            $table->dropColumn('to');
        });
    }
}
