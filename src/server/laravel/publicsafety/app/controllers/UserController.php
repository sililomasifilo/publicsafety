<?php

class UserController extends \BaseController {

        /*
         * This resource uses $key and $id to identify itself.
         * $key is the hash that each user uses to identify himself and
         * is used whenever some user data needs to be updated.
         * $id is just the user id and is used to display information about
         * the user ie when no data is modified.
         */

        #TODO: add validator filter in the controller constructor
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
                $user = new User;
        
                $user->mobile_number = Request::get('mobile_number');
                $user->email_id = Request::get('email_id');
                $user->name = Request::get('name');
                $user->password = Request::get('password');
                $user->latitude = Request::get('latitude');
                $user->longitude = Request::get('longitude');
                
                $key = User::createKey(Request::get('mobile_number'), Request::get('password'));
                
                $user->key = $key;

                $status = $user->save();

                if($status)
                {
                        return Response::json(array(
                                'error' => 'false',
                                'message' => 'User created.',
                                'key' => $key
                        ), 200);
                }

                #probably an error writing to the database
                return Error::serverError();
        }

        /**
         * Display user with $id.
         * This is for viewing a users public profile and hence $id is user.
         * The usage of $id and $key are different.
         *
         * @param  int  $id
         * @return Response
         */
        public function show($id)
        {
                $user = User::find($id);

                if(!$user)
                {
                        return Error::notFound('User'); 
                }

                return Response::json(array(
                        'error' => 'false',
                        'user' => $user->toArray()
                ), 200);
        }

        /**
         * Update the user with unique identifier $key.
         *
         * @param  int  $key
         * @return Response
         */
        public function update($key)
        {
                $user = User::getFromKey($key);
                if(!$user)
                {
                        return Error::notFound('User');
                }
                
                #I could've used ternary operators but they look ugly 
                #and PHP is ugly enough already.

                if(Request::get('mobile_number'))
                {
                        $user->mobile_number = Request::get('mobile_number');
                }

                if(Request::get('email_id'))
                {
                        $user->email_id = Request::get('email_id');
                }

                if(Request::get('name'))
                {
                        $user->name = Request::get('name');
                }

                if(Request::get('password'))
                {
                        $user->password = Hash::make(Request::get('password'));
                }

                if(Request::get('latitude'))
                {
                        $user->latitude = Request::get('latitude');
                }

                if(Request::get('longitude'))
                {
                        $user->longitude = Request::get('longitude');
                }

                $status = $user->save();

                if($status)
                {
                        return Response::json(array(
                                'error' => 'false',
                                'message' => 'User updated.'
                        ), 200);
                }
                
                return Error::serverError();                
        }

        /**
         * Remove user with unique identifier $key.
         *
         * @param  int  $key
         * @return Response
         */
        public function destroy($key)
        {
                $user = User::getFromKey($key);
                if(!$user)
                {
                        return Error::notFound('User');
                }
                $status = $user->delete();

                if($status)
                {
                        return Response::json(array(
                                'error' => 'false',
                                'message' => 'User deleted.'
                        ), 200);
                }
                
                return Error::serverError();                
        }
}
