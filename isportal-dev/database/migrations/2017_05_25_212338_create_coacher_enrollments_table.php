<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoacherEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coacher_enrollments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coacher_id')->unsigned();
            $table->integer('coaching_team_id')->unsigned();
            //$table->integer('activity_id')->unsigned();
            $table->timestamps();

            $table->unique(array('coacher_id'));

            $table->foreign('coacher_id')->references('id')->on('users');
            $table->foreign('coaching_team_id')->references('id')->on('coaching_teams');
           // $table->foreign('activity_id')->references('id')->on('activities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coacher_enrollments');
    }
}