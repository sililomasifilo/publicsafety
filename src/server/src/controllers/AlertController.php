<?php

#TODO: add validation filter to the controller
class AlertController extends \BaseController {

        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
        public function index()
        {
                $alerts = Alert::with('alert_event')->get();
                
                if(is_null($alerts))
                {
                        return Error::notFound('Alerts'); 
                }
                
                return Response::json(array(
                        'error' => 'false',
                        'alerts' => $alerts->toArray()
                ), 200);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @return Response
         */
        public function store()
        {
                $user = HaiyyaUser::getFromKey(Request::get('key'));
                
                if(is_null($user))
                {
                        return Error::notFound('User'); 
                }

                $alert = new Alert;
                $alert->user_id = $user->id;
                $alert->type = Request::get('type');
                $alert->message = Request::get('message');
                $alert->latitude = Request::get('latitude');
                $alert->longitude = Request::get('longitude');

                $status = $alert->save();

                if($status)
                {
                        $alertStatus = Alert::push($user->id, $alert->latitude, $alert->longitude, $alert->message);
                        if($alertStatus)
                        {
                                Log::info("Alert created by user: ".strval($user->id));
                                return Response::json(array(
                                        'error' => 'false',
                                        'message' => 'Alert added.'
                                ), 200);
                        }
                        Log::warning("Alert push by user ".strval($user->id)." failed.");
                        return Error::serverError();       
                }
                
                Log::warning("Alert save by user ".strval($user->id)." failed.");
                return Error::serverError();       
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return Response
         */
        public function show($id)
        {
                $alerts = Alert::with('alert_event')
                        ->where('id', '=', $id)
                        ->get();
                
                if(is_null($alerts))
                {
                        return Error::notFound('Alerts'); 
                } 

                return Response::json(array(
                        'error' => 'false',
                        'alerts' => $alerts->toArray() 
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
