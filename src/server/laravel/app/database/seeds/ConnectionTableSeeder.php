<?php
class ConnectionTableSeeder extends Seeder
{
        public function run()
        {
                DB::table('connections')->delete();

                Connection::create(array(
                        'user_id' => '1',
                        'friend_id' => '2'
                )); 
        }
}
?>
