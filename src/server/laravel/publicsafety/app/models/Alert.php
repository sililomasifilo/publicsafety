<?php
class Alert extends Eloquent
{
        protected $table = 'alerts';

        public function user()
        {
                return $this->belongsTo('User');
        }

        public function alert_event()
        {
                return $this->hasMany('AlertEvent');
        }
}
?>
