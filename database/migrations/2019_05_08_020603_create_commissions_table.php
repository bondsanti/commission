<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('team_id');
            $table->foreign('team_id')->references('id')->on('teams');
            $table->unsignedInteger('sub_team_id');
            $table->foreign('sub_team_id')->references('id')->on('sub_teams');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->double('commission')->default(0)->nullable();
            $table->integer('mortgage')->default(0)->nullable();
            $table->double('total')->default(0)->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->string('sale_id')->nullable()->comment('คนที่ขายได้');
            $table->integer('approve_limit')->default(0);
            $table->integer('pid')->nullable();
            $table->string('customer_name')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commissions');
    }
}