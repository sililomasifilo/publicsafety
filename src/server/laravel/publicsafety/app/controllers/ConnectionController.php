<?php

class ConnectionController extends \BaseController {

        #TODO: add validation filter inside constructor controller

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

                $user = User::getFromKey(Request::get('key'));       
        
                if(!$user)
                {
                        return Error::notFound('User');
                }
  
                $status = Connection::addConnections($user->id, Request::get('connections'));

                if($status == 'success')
                {
                        return Response::json(array(
                                'error' => 'false',
                                'message' => 'Connections added.'
                        ), 200);
                }

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
                $user = User::getFromKey($key);
                if(!$user)
                {
                        return Error::notFound('User');
                }

                $result = Connection::userConnections($user->id);
                
                if(!$result)
                {
                        return Error::serverError();        
                }
                
                return Response::json(array(
                        'error' => 'false',
                        'connections' => $result[1]->toArray()
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
