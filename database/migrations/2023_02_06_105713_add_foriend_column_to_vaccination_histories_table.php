<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForiendColumnToVaccinationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vaccination_histories', function (Blueprint $table) {
            $table->unsignedInteger('vaccine_lot_id');
            $table->foreign('vaccine_lot_id')->references('id')->on('vaccine_lots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vaccination_histories', function (Blueprint $table) {
            $table->dropColumn('vaccine_lot_id');
        });
    }
}
