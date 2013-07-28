<?php

class AlertEvent extends Eloquent
{
        protected $table = 'alert_events';

        public function alert()
        {
                return $this->belongsTo('Alert');
        }
}

?>
