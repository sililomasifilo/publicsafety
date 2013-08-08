<?php
class Alert extends Eloquent
{
        protected $table = 'alerts';

        public function user()
        {
                return $this->belongsTo('HaiyyaUser');
        }

        public function alert_event()
        {
                return $this->hasMany('AlertEvent');
        }
        
        public static function pushNotifs($user_id, $latitude, $longitude, $message)
        {
                $users = Distance::inArea($latitude, $longitude);
                foreach($user as $users)
                {
                        if($user->device == "Android")
                                Push::android($user->deviceToken, $message);
                        else
                                Push::iOS($user->deviceToken, $message);
                }

        }
}
?>
