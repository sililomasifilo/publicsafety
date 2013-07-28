<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'users';

        /**
         * The attributes excluded from the model's JSON form.
         *
         * @var array
         */
        protected $hidden = array('password');

        /**
         * Get the unique identifier for the user.
         *
         * @return mixed
         */
        public function getAuthIdentifier()
        {
                return $this->getKey();
        }

        /**
         * Get the password for the user.
         *
         * @return string
         */
        public function getAuthPassword()
        {
                return $this->password;
        }

        /**
         * Get the e-mail address where password reminders are sent.
         *
         * @return string
         */
        public function getReminderEmail()
        {
                return $this->email;
        }

        /*
         * Assigns connections between multiple users
         */
        public function connection()
        {
                return $this->belongsToMany('User', 'connections', 'user_id', 'friends_id');
        }

        public function alert()
        {
                return $this->hasMany('Alert');
        }

        /*
         *
         */
        public static function createKey($mobile_number, $password)
        {
                #currently using the laravel hash function.
                #can be replaced in future if needed.
                return Hash::make($mobile_number.$password);
        }

        /*
         * takes the unique identifier for the user and returns the user object.
         *
         * @param = $key
         * @return Object
         */
        public static function getFromKey($key)
        {
                #made into a separate function just in case some more complicated
                #algorithm were to be implemented for identification, it'd be
                #better to have it in once place.
                return User::where('key', '=', $key)
                        ->get();
        }

}
