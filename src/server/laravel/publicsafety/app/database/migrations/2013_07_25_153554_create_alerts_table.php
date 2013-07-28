<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertsTable extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
                Schema::create('alerts', function(Blueprint $table)
                {
                        $table->increments('id');
                        $table->integer('user_id');
                        $table->string('type');
                        $table->string('message');         
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
                Schema::drop('alerts');
        }

}
