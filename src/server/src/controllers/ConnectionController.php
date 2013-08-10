<?php

#TODO: add validation filter inside constructor controller
class ConnectionController extends \BaseController {

        public function __construct()
        {
        }
        /**
         * Display a listing of all the users.
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
                #takes 'key' and array of connections as input.
                #need to document it soon.
                $user = HaiyyaUser::getFromKey(Request::get('key'));       
        
                if(is_null($user))
                {
                        return Error::notFound("User");
                }
  
                $status = Connection::addConnections($user->id, Request::get('connections'));

                if($status == 'success')
                {
                        return Response::json(array(

                                'error' => 'false',
                                'message' => 'Connections added.'
                        ), 200);
                }
                else if($status == "failure")
                {
                        Log::warning("Adding connections for user ".strval($user->id)." failed.");
                        return Error::serverError();
                }

                Log::warning("Adding some connections for user".strval($user->id)."failed.");
                return Error::serverError();
        }

        /**
         * Display the specified connection.
         * Remember this $key passed is the user key and not the connection 
         * id. Connection is just a relation so its id will not be considered
         * anywhere.
         *
         * @param  int  $key
         * @return Response
         */
        public function show($key)
        {
                $user = HaiyyaUser::getFromKey($key);
                if(is_null($user))
                {
                        return Error::notFound("User");
                }

                $result = Connection::userConnections($user->id);
                #returns an object with all users or false if 
                #user doesnt exist. 
                if(is_null($result))
                {
                        Log::warning("Fetching connections for user ".strval($user->id)." failed.");
                        return Error::serverError();
                }
                
                return Response::json(array(
                        'error' => 'false',
                        'connections' => $result->toArray()
                ), 200);
        }
        
        /**
         * Update the specified resource from storage.
         *
         * @param  int  $id
         * @return Response
         */
        public function update()
        {
                #we may want to add an option to update user
                #connections later.
                return Error::notAllowed('PUT');
        }
        
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return Response
         */
        public function destroy()
        {
                return Error::notAllowed('DELETE');
        }
}
