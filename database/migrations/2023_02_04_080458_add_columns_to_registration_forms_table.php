<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToRegistrationFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registration_forms', function (Blueprint $table) {
            $table->string('injection_times', 100);
            $table->unsignedInteger('vaccine_id');
            $table->foreign('vaccine_id')->references('id')->on('vaccines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registration_forms', function (Blueprint $table) {
            $table->dropColumn(['injection_times', 'vaccine_id']);
        });
    }
}
