<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertEventsTable extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
                Schema::create('alert_events', function(Blueprint $table)
                {
                        $table->increments('id');
                        $table->integer('alert_id');    
                        $table->integer('user_id');
                        $table->string('type');
                        $table->string('message');
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
                Schema::drop('alert_events');
        }

}
