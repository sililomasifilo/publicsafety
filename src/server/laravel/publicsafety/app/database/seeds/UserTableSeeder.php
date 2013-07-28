<?php
class UserTableSeeder extends Seeder
{
        public function run()
        {
                DB::table('users')->delete();

                User::create(array(
                        'mobile_number' => 1234567890,
                        'email_id' => 'a@b.com',
                        'password' => Hash::make('a@b.com'),
                        'name' => 'a',
                        'latitude' => 123321.1231,
                        'longitude' => 232342.2342
                ));

                User::create(array(
                        'mobile_number' => 0987654321,
                        'email_id' => 'b@a.com',
                        'password' => Hash::make('b@a.com'),
                        'name' => 'b',
                        'latitude' => 123321.1231,
                        'longitude' => 232342.2342
                ));
        }
}
?>
