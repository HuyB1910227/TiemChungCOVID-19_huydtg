<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->date('vaccination_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('status');
            $table->timestamps();
            $table->unsignedInteger('vaccine_id');
            $table->foreign('vaccine_id')->references('id')->on('vaccines');
            $table->unsignedInteger('immunization_unit_id');
            $table->foreign('immunization_unit_id')->references('id')->on('immunization_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}