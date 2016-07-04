<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('motivation');
            $table->integer('priority');
            $table->enum('state', array('pending', 'accepted', 'rejected'));
            $table->timestamps('created_at');

            $table->integer('entity_id')->unsigned();
            $table->integer('activity_id')->unsigned();


            $table->unique(array('entity_id','activity_id'));

            $table->foreign('entity_id')->references('id')->on('users');
            $table->foreign('activity_id')->references('id')->on('activities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('enrollments');
    }
}
