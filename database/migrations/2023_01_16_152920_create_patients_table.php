<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('full_name');
            $table->string('identify_card', 15)->unique();
            $table->string('address');
            $table->string('phone', 11);
            $table->integer('gender')->comment('nam: 1, nu: 0');
            $table->date('date_of_birth');
            $table->string('career')->nullable();
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
        Schema::dropIfExists('patients');
    }
}
