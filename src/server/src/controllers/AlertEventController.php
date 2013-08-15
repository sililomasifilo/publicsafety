<?php

#TODO: 
#add validation filter to the controller
#push notification on alert event?
class AlertEventController extends \BaseController {

        /*
         * $key universally means the unique key used to identify the user.
         * $id is strictly restricted to the id of the resource under consideration.
         */

        #TODO: add validator filter in the controller constructor.
        public function __construct()
        {
        } 
 
        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
        public function index()
        {
                return Error::notAllowed('GET'); 
        }

        /**
         * Store a newly created resource in storage.
         *
         * @return Response
         */
        public function store()
        {
                #when an alert event is created, do you send a push 
                #notification to the user who originally created the 
                #alert? if so, that needs to be implemented.
                $user = HaiyyaUser::getFromKey(Request::get('key'));
                if(is_null($user))
                {
                        return Error::notFound('User');
                }

                $alert_event = new AlertEvent;
                
                $alert_event->alert_id = Request::get('alert_id');
                $alert_event->user_id = $user->id;
                $alert_event->type= Request::get('type');
                $alert_event->message = Request::get('message');

                $status = $alert_event->save();

                if($status)
                {
                        Log::info("Alert even created for alert: ".strval(Request::get('alert_id'))." by user: ".strval($user->id));
                        return Response::json(array(
                                'error' => 'false',
                                'message' => 'Alert Event created.'
                        ), 200);
                }
                
                Log::warning("Alert event save by user ".strval($user->id)." failed.");
                return Error::serverError(); 
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return Response
         */
        public function show($alert_id)
        {
                $alert_event = AlertEvent::find($id);
                if(is_null($alert_event))
                {
                        return Error::notFound('Alert Event');
                }

                return Response::json(array(
                        'error' => 'false',
                        'alert_event' => $alert_event->toArray()
                ), 200);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  int  $id
         * @return Response
         */
        public function update($id)
        {
                return Error::notAllowed('PUT');
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return Response
         */
        public function destroy($id)
        {
                return Error::notAllowed('DELETE');
        }

}
