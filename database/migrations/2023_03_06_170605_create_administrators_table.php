<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('full_name');
            $table->string('avatar', 255)->nullable()->default('admin/img/default.jpg');
            $table->string('identify_card', 15)->unique();
            $table->string('phone', 11);
            $table->date('date_of_birth');
            $table->integer('gender');
            $table->string('address');
            $table->timestamps();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrators');
    }
}
