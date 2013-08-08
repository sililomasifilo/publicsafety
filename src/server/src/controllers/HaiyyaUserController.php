<?php

#TODO: add validator filter in the controller constructor
class HaiyyaUserController extends \BaseController {

        /*
         * This resource uses $key and $id to identify itself.
         * $key is the hash that each user uses to identify himself and
         * is used whenever some user data needs to be updated.
         * $id is just the user id and is used to display information about
         * the user ie when no data is modified.
         */

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
                return Error::notAllowed("GET");
        }

        /**
         * Store a newly created resource in storage.
         *
         * @return Response
         */
        public function store()
        {
                $user = HaiyyaUser::where('mobile_number', '=', Request::get('mobile_number'))
                        ->orwhere('email_id', '=', Request::get('email_id'))
                        ->first();
                if($user)
                {
                        return Response::json(array(
                                'error' => 'true',
                                'message' => 'User exists.',
                        ), 400);
                }
                $user = new HaiyyaUser();

                $user->mobile_number = Request::get('mobile_number');
                $user->email_id = Request::get('email_id');
                $user->name = Request::get('name');
                $user->password = Request::get('password');
                $user->latitude = Request::get('latitude');
                $user->longitude = Request::get('longitude');
                $user->deviceToken = Request::get('deviceToken');
                $key = HaiyyaUser::createKey(Request::get('mobile_number'), Request::get('password'));

                $user->key = $key;

                $status = $user->save();

                if($status)
                {
                        Log::info("Created user: ".strval($user->id));
                        return Response::json(array(
                                'error' => 'false',
                                'message' => 'User created.',
                                'key' => $key
                        ), 200);
                }

                #probably an error writing to the database
                Log::warning("User creation failed.");
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
                $user = HaiyyaUser::find($id);

                if(is_null($user))
                {
                        return Error::notFound("User");
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
                $user = HaiyyaUser::getFromKey($key);
                if(is_null($user))
                {
                        return Response::json(array(
                                'error' => 'true',
                                'message' => 'user not found'
                        ), 404);
                        return Error::notFound("User");
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
                        Log::info("User ".strval($user->id)." updated.");
                        return Response::json(array(
                                'error' => 'false',
                                'message' => 'User updated.'
                        ), 200);
                }

                Log::warning("User ".strval($user->id)." update failed.");
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
                $user = HaiyyaUser::getFromKey($key);
                if(is_null($user))
                {
                        return Error::notFound("User");
                }
                $status = $user->delete();

                if($status)
                {
                        Log::info("User ".strval($user->id)." deleted.");
                        return Response::json(array(
                                'error' => 'false',
                                'message' => 'User deleted.'
                        ), 200);
                }

                Log::warning("Failed to delete user ".strval($user->id));
                return Error::serverError();
        }
}
