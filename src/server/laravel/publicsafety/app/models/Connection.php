<?php

class Connection extends Eloquent
{
        protected $table = 'connections';

        /*
         * creates connections for the given user if connection users exist in the
         * database.
         *
         * @param $id, array
         * @return string
         */
        public static function addConnections($user_id, $connections)
        {
                foreach($connections as $connection)
                {
                        $friend = User::where('mobile_number', '=', $connection)
                                ->take(1)
                                ->get();
                        #we wouldn't do a status check here 
                        #because duplicate connections would error out.
                        Connection::create($user_id, $friend->id);
                }
                #Delete duplicate records here.
                #MySql vodoo to remove duplicate rows.
                #This is evil since it depends on the database engine.
                DB::query('ALTER IGNORE TABLE connections ADD UNIQUE INDEX(user_id, friend_id)');
         }

        /*
         * returns all the connections belonging to the user.
         *
         * @param $id
         * @return array
         */
        public static function userConnections($id)
        {
                return Connection::where('user_id', '=', $id)
                        ->orwhere('friend_id', '=', $id)
                        ->get();
        }
}

?>
