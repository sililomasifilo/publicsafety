<?php
class HaiyyaUserTableSeeder extends Seeder
{
        public function run()
        {
                DB::table('haiyyausers')->delete();

                HaiyyaUser::create(array(
                        'mobile_number' => 1234567890,
                        'email_id' => 'a@b.com',
                        'password' => Hash::make('a@b.com'),
                        'key' => Hash::make('a'.'a@b.com'),
                        'deviceToken' => '123123123',
                        'name' => 'a',
                        'latitude' => 123321.1231,
                        'longitude' => 232342.2342
                ));

                HaiyyaUser::create(array(
                        'mobile_number' => 0987654321,
                        'email_id' => 'b@a.com',
                        'password' => Hash::make('b@a.com'),
                        'name' => 'b',
                        'key' => Hash::make('a'.'b@a.com'),
                        'deviceToken' => '123123123',
                        'latitude' => 123321.1231,
                        'longitude' => 232342.2342
                ));
        }
}
?>
