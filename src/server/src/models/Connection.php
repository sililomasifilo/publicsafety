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
                $count = 0;
                $success = 0;
                foreach($connections as $connection)
                {
                        $friend = HaiyyaUser::where('mobile_number', '=', $connection)
                                ->first();        
                        #we wouldn't do a status check here 
                        #because duplicate connections would error out.
                        if(Connection::create($user_id, $friend->id))
                        {
                                $success++;
                        }
                        $count++;
                }
                #Delete duplicate records here.
                #MySql vodoo to remove duplicate rows.
                #This is evil since it depends on the database engine.
                DB::query('ALTER IGNORE TABLE connections ADD UNIQUE INDEX(user_id, friend_id)');
                if($count == $success)
                {
                        return "success";
                }
                else if($success == 0)
                {
                        return "failure";
                }
                return "some added";
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
