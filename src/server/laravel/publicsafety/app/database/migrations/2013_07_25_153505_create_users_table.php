<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
                Schema::create('users', function(Blueprint $table)
                {
                        $table->increments('id');
                        $table->integer('mobile_number')->unique();
                        $table->string('email_id')->unique();
                        $table->string('password');
                        $table->string('name');
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
                Schema::drop('users');
        }

}
