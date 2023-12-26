<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccineLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccine_lots', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('lot_code');
            $table->unsignedInteger('quantity');
            $table->date('transaction_date');
            $table->date('expired_date');
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
        Schema::dropIfExists('vaccine_lots');
    }
}