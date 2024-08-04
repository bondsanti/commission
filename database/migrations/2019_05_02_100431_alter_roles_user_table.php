<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRolesUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->double('commission')->default(0);
            $table->integer('mortgage')->default(0);
            $table->integer('SALE')->default(0);
            $table->integer('TL')->default(0);
            $table->integer('MG')->default(0);
            $table->integer('SM')->default(0);
            $table->integer('AVP')->default(0);
            $table->integer('VP')->default(0);
            $table->integer('MD')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            //
        });
    }
}
