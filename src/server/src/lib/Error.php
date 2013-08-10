<?php

/*
 * A generic Error handling class to respond to errors occured with 
 * appropriate message and HTTP status code.
 */
class Error
{
        public static function notFound($resource)
        {
                return Response::json(array(
                        'error' => 'true',
                        'message' => $resource." not found."
                ), 404);
        }
        
        public static function notAllowed($method)
        {
                return Response::json(array(
                        'error' => 'true',
                        'message' => $method.' not allowed on this resource.'
                ), 405);
        }

        public static function serverError()
        {
                return Response::json(array(
                        'error' => 'true',
                        'message' => 'Action could not be completed.'
                ), 500);
        }
}
?>
