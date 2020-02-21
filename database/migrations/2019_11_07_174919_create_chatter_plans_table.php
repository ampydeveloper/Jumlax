<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatterPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(('charter_planes'), function ($table) {
            $table->unsignedBigInteger('user_id')->after('id');;
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name')->after('user_id')->nullable();
            $table->integer('seats')->after('name')->nullable();
            $table->double('fare', 8, 2)->after('seats')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chatter_plans');
    }
}
