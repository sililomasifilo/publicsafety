<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHaiyyausersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('haiyyausers', function(Blueprint $table)
        {
                $table->increments('id');
                $table->integer('mobile_number')->unique();
                $table->string('email_id')->unique();
                $table->string('key');
                $table->string('password');
                $table->string('name');
                $table->string('deviceToken');
                #last seen at location
                $table->float('latitude');
                $table->float('longitude');
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
            Schema::drop('haiyyausers');
	}

}
