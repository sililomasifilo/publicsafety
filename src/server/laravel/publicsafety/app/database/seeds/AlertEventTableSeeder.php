<?php
class AlertEventTableSeeder extends Seeder
{
        public function run()
        {
                DB::table('alert_events')->delete();

                AlertEvent::create(array(
                        'alert_id' => 1,
                        'user_id' => 2,
                        'type' => 'yes',
                        'message' => 'coming'
                ));

                AlertEvent::create(array(
                        'alert_id' => 2,
                        'user_id' => 1,
                        'type' => 'no',
                        'message' => 'sorry!'
                ));
        }
}
?>
