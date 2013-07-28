<?php

class AlertController extends \BaseController {

        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
        public function index()
        {
                $alerts = Alert::with('alert_event', 'user')->get();
                
                if(!$alerts)
                {
                        return Error::notFound('Alert');
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
                $user = User::getFromKey(Request::get('key'));
                
                if(!$user)
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
                        return Response::json(array(
                                'error' => 'false',
                                'message' => 'Alert added.'
                        ), 200);
                }
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
                $alerts = Alert::with('alert_event', 'user')
                        ->where('id', '=', $id)
                        ->get();
                
                if(!$alerts)
                {
                        return Error::notFound('Alert');
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
