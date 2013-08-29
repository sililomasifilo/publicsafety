/* 

    Global settings for the JS client
*/

// Server URLs, etc.
var serverBaseUrl = "http://localhost/publicsafety/laravel/public/index.php/api/v1";
	
var serverRelativeUrls = {
    'userCollection' : 'user',
    'friends' : 'connection',
    'alertCollection' : 'alert',
    'alertEventCollection' : 'alertevent'
};

// 5s by default
var refreshInterval = 5000;


var gUserId = "sumitg";

var callusinglocation = '#mylocation';

function getLocation()
{
//	callusinglocation = $('#mylocation');
	$(callusinglocation).html("updating..");
	if (navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
  else {
	  	callusinglocation.html("Geolocation is not supported by this browser.");
  }
}

function showPosition(position)
  {
    var pos = "L ";
    pos += position.coords.latitude;
    $(callusinglocation).html(pos);	
  }
