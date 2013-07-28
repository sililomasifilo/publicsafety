publicsafety
============

## public safety server

This contains all the API source that the mobile client interacts with.
All the APIs defined here are written in the Laravel Framework for PHP and follow RESTful standards.

This implementation is still incomplete.

Some small changes remain to be made.

## files of interest 
> app/controllers

> app/models

> app/databases

> app/lib

> app/filters.php

> app/routes.php

## TODO:
> Tests need to be written.

> Replace user:pass authentication with HMAC.

> Push Notification needs to be implemeted.

> Validations need to be implemented.

> Request response format needs to be filled.

> Cleaner url.

> Complete request/response documentation.


##Installation
```shell
git clone https://github.com/code-for-india/publicsafety
git checkout server
cp -R publicsafety/src/server/laravel /var/www/ 
```

##Accessing APIs via command line
###Example for user resource

> GET:

        curl --user a:a@b.com localhost/publicsafety/publicsafety/public/index.php/api/vi1/user/1
> POST:

        curl --user a:a@b.com "mobile_number=2873462837&email_id=a@e.com&name=a&password=a@e.com&latitude=343534.343&longitude=123123.21" localhost/publicsafety/publisafety/public/index.php/api/v1/user 
> PUT:                

        curl --user a:a@b.com -X PUT "email=a@c.com" "" localhost/publicsafety/publisafety/public/index.php/api/v1/user 
> DELETE: 

        curl --user a:a@b.com -X DELETE "" localhost/publicsafety/publisafety/public/index.php/api/v1/user/1 

##List of APIs:
The RESTful APIs are made of four resources.
Base url : /localhost/publicsafety/publicsafety/public/index.php/api/v1/
# > /user

 * GET:

        Not allowed.   

 * GET/$id:
         
        Request:

        Response:

 * POST: 
        
        Request:

        Response:

 * PUT:  
       
        Request:

        Response:

 * DELETE:        

        Request:

        Response:

# > /connection

 * GET:

        Not allowed.

 * GET/$id:

        Request:

        Response:

 * POST:

        Request:

        Response:

 * PUT:

        Not allowed.

 * DELETE:

        Not allowed.

# > /alert

 * GET:

        Request:

        Response: 

 * GET/$id:

        Request:

        Response:

 * POST:

        Request:

        Response: 

 * PUT:

        Not allowed.

 * DELETE:

        Not allowed.

# > /alertevent

 * GET:

        Not allowed.

 * GET/$id:

        Request:

        Response:

 * POST:

        Request:

        Response:

 * PUT:

        Not allowed.

 * DELETE:

        Not allowed.

