<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('full_name');
            $table->string('employee_id');
            $table->string('identify_card', 15)->unique();
            $table->string('phone', 11);
            $table->date('date_of_birth');
            $table->integer('gender');
            $table->string('address');
            $table->timestamps();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('position_id');
            $table->foreign('position_id')->references('id')->on('positions');
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
        Schema::dropIfExists('employees');
    }
}