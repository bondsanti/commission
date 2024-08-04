<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCommiccionSaleinAddMortgage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commission_salein', function (Blueprint $table) {
            $table->integer('mortgage')->default(0);
            $table->double('point')->default(0);
            $table->tinyInteger('approved')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commission_salein', function (Blueprint $table) {
            //
        });
    }
}