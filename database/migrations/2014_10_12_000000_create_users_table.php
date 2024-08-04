<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->rememberToken();
            $table->string('thai_name')->nullable();
            $table->string('eng_name')->nullable();
            $table->date('join_date')->nullable();
            $table->string('code')->nullable();
            $table->integer('team_id')->unsigned()->nullable();
            // $table->foreign('team_id')->references('id')->on('teams');
            $table->integer('sub_team_id')->unsigned()->nullable();
            // $table->foreign('sub_team_id')->references('id')->on('sub_teams');
            $table->integer('company_id')->nullable();
            $table->double('commission')->default(0)->nullable();
            $table->string('card_id')->nullable();
			$table->string('line_id')->nullable();
			$table->string('address')->nullable();
			$table->string('soi')->nullable();
			$table->string('district')->nullable();
			$table->string('amphur')->nullable();
			$table->string('provice')->nullable();
			$table->string('zipcode')->nullable();
			$table->string('bank_name')->nullable();
			$table->string('bank_number')->nullable();
            $table->integer('lead_id')->nullable();
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
        Schema::dropIfExists('users');
    }
}