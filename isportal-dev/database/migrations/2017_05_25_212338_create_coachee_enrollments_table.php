<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoacheeEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coachee_enrollments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coachee_id')->unsigned();
            $table->integer('coaching_team_id')->unsigned();
            $table->timestamps();

            $table->unique(array('coachee_id'));

            $table->foreign('coachee_id')->references('id')->on('users');
            $table->foreign('coaching_team_id')->references('id')->on('coaching_teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coachee_enrollments');
    }
}