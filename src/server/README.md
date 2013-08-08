publicsafety
============

## public safety server

This contains all the API source that the mobile client interacts with.
All the APIs defined here are written in the Laravel Framework for PHP and follow RESTful standards.

This implementation is still incomplete.

Some small changes remain to be made.

## TODO:
> Tests need to be written.

> Replace user:pass authentication with HMAC.

> Validations need to be implemented.


##Installation
```shell
git clone https://github.com/code-for-india/publicsafety
git checkout server
cp -R publicsafety/src/server/ /var/www/ 
```

##Accessing APIs via command line
###Example for user resource

> GET:

        curl --user a:a@b.com localhost/publicsafety/laravel/public/index.php/api/vi1/user/1
> POST:

        curl --user a:a@b.com "mobile_number=2873462837&email_id=a@e.com&name=a&password=a@e.com&latitude=343534.343&longitude=123123.21&deviceToken=1312341234" localhost/publicsafety/laravel/public/index.php/api/v1/user 
> PUT:                

        curl --user a:a@b.com -X PUT "email=a@c.com" "" localhost/publicsafety/laravel/public/index.php/api/v1/user 
> DELETE: 

        curl --user a:a@b.com -X DELETE "" localhost/publicsafety/laravel/public/index.php/api/v1/user/1 

##List of APIs

The RESTful APIs are made of four resources.
Base url : /localhost/publicsafety/publicsafety/public/index.php/api/v1/
Every API except the /user POST, requires a username:password authentication to work.
### /user

 * GET:

        Not allowed.   

 * GET/$key:
         
        Response:
                {
                        'error': false,
                        'user':
                                {
                                },
                }
        usernotfound

 * POST: 
        
        Request:
                {
                        'mobile_number': ,
                        'email_id': ,
                        'name': ,
                        'password': ,
                        'latitude': ,
                        'longitude': ,
                        'deviceToken': ,
                }
        
        Response:
                {
                        'error': false,
                        'message': 'User created.'
                        'key': ,
                }
        

 * PUT:  
       
        Response:
                {
                       'error': false,
                       'message': 'User updated.' 
                }

 * DELETE:        

        Response:
                {
                        'error': 'false',
                        'message': 'User deleted.'
                }

### /connection

 * GET:

        Not allowed.

 * GET/$id:

        Response:
                {
                        'error': false,
                        'message': 'Connections added.'
                }
        server error

 * POST:

        Request:
                {
                        'key': ,
                        'connections':
                                [
                                        'connection1',
                                        'connection2',
                                        ...
                                ] 
                }

        Response:
                {
                        'error' => 'false',
                        'message' => 'Connections added.'
                }
        usernotfound, server error

 * PUT:

        Not allowed.

 * DELETE:

        Not allowed.

### /alert

 * GET:

        Response: 
                {
                        'error': 'false',
                        'alerts':
                                [
                                  {
                                    'alert1':
                                    {
                                       'user_id': ,
                                       'type': ,
                                       'message': ,
                                       'latitude': ,
                                       'longitude': , 
                                    }
                                    ...    
                                  }
                                ]
                }
        
 * GET/$id:

        Response:
                {
                        'error': 'false',
                        'alerts': 
                                [
                                        'user_id': ,
                                        'type': ,
                                        'message': ,
                                        'latitude': ,
                                        'longitude': ,
                                ] 
                }

 * POST:

        Request:
                {
                        'key': ,
                        'type': ,
                        'message': ,
                        'latitude': ,
                        'longitude': , 
                }

        Response: 
                {
                        'error': 'false',
                        'message': 'Alert Added.'
                }

 * PUT:

        Not allowed.

 * DELETE:

        Not allowed.

### /alertevent

 * GET:

        Not allowed.

 * GET/$id:

        Response:
                {
                  'error': 'false',
                  'alert_event': 
                        [
                          {
                            'alert_event1':
                            {
                              'alert_id': ,
                              'user_id': ,
                              'type': ,
                              'message': ,
                            }
                            ...
                          }
                        ]
                }

 * POST:

        Request:
                {
                        'key': ,
                        'alert_id': ,
                        'type': ,
                        'message': ,
                }

        Response:
                {
                        'error': 'false',
                        'message': 'Alert Event created.'
                }

 * PUT:

        Not allowed.

 * DELETE:

        Not allowed.

##Errors:
In case of any errors, standard json responses will be returned.
StatusCode: 404
###notFound

        {
                'error': 'true',
                'message': '{Resource} not found.'
        }

###notAllowed
StatusCode: 405

        {
                'error': 'true',
                'message': '{Verb} not allowed on this resource.'
        }

###serverError
Status Code: 500

        {
                'error': 'true',
                'message': 'Action could not be completed.'
        }
