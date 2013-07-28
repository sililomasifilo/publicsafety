<?php
class AlertTableSeeder extends Seeder
{
        public function run()
        {
                DB::table('alerts')->delete();

                Alert::create(array(
                        'user_id' => 1,
                        'type' => 'eveteasing',
                        'message' => 'help please!',
                        'latitude' => 123321.1231,
                        'longitude' => 232342.2342         
                ));        

                Alert::create(array(
                        'user_id' => 2,
                        'type' => 'robbery',
                        'message' => 'please!',
                        'latitude' => 123321.1231,
                        'longitude' => 232342.2342         
                ));        
        }
}
?>
