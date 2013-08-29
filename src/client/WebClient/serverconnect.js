/* 

    Helper methods to interface with server
*/

/* should be specified in global file */
var serverSettings;
var UNITTEST=true;

var UNITTEST_alerts_response = 
' {"error":"false","alerts":[{"id":1,"user_id":1,"type":"eveteasing","message":"help please!","latitude":18.9760,"longitude":72.8258,"created_at":"2013-08-19 01:50:36","updated_at":"2013-08-19 01:50:36","alert_event":[{"id":1,"alert_id":1,"user_id":2,"type":"yes","message":"coming","created_at":"2013-08-19 01:50:36","updated_at":"2013-08-19 01:50:36"}],"user":{"id":1,"mobile_number":1234567890,"email_id":"a@b.com","key":"$2y$08$AUn5B6yRGc6WviYhjIY1Zue1JPjTGX4lrpyU5KQat6e6H7jQICFA2","name":"a","deviceToken":"123123123","latitude":123321.1171875,"longitude":232342.234375,"created_at":"2013-08-19 01:50:36","updated_at":"2013-08-19 01:50:36"}},{"id":2,"user_id":2,"type":"robbery","message":"please!","latitude":18.9750,"longitude":72.8268,"created_at":"2013-08-19 01:50:36","updated_at":"2013-08-19 01:50:36","alert_event":[{"id":2,"alert_id":2,"user_id":1,"type":"no","message":"sorry!","created_at":"2013-08-19 01:50:36","updated_at":"2013-08-19 01:50:36"}],"user":{"id":2,"mobile_number":0,"email_id":"b@a.com","key":"$2y$08$wT302cGFRJEQ9.YmEABzPOxCxIutjcapcvA4u9ORt8hZWJqRlB9fS","name":"b","deviceToken":"123123123","latitude":123321.1171875,"longitude":232342.234375,"created_at":"2013-08-19 01:50:36","updated_at":"2013-08-19 01:50:36"}}]}';

var UNITTEST_user_response = 
'{"error":"false","user":{"id":1,"mobile_number":1234567890,"email_id":"a@b.com","key":"$2y$08$AUn5B6yRGc6WviYhjIY1Zue1JPjTGX4lrpyU5KQat6e6H7jQICFA2","name":"a","deviceToken":"123123123","latitude":123321.1171875,"longitude":232342.234375,"created_at":"2013-08-19 01:50:36","updated_at":"2013-08-19 01:50:36"}}';


/*
 * make HTTP GET call to get latest set of alerts for this user
 * 
 * GET:
 * GET/$id:
 */
// return true if success. fill in results in passed in array.
function getAlerts(alertdatahandler, alertid) {
    var alertsUrl = serverBaseUrl + "/" + serverRelativeUrls['alertCollection'];
    var response = new Object();

try {
    if (UNITTEST == false) {
        $.getJSON(alertsUrl, alertdatahandler);
    } else {
        response = $.parseJSON(UNITTEST_alerts_response);
        alertdatahandler(response);
    }
} catch(err) {
	alert(err.toString());	
}

}

/*
 * Fetch user info from server.
 * User id is required input.
 */
function getUserFromServer(userdatahandler, userid) {
    var userUrl = serverBaseUrl + "/" + serverRelativeUrls['userCollection'] + "/" + userid;
    var response = new Object();

try {
    if (UNITTEST == false) {
        $.getJSON(userUrl, userdatahandler);
    } else {
        response = $.parseJSON(UNITTEST_user_response);
        userdatahandler(response);
    }
} catch(err) {
	alert(err.toString());	
}

}

/* migrate this to webworker, for now, taking fast path.

var w;

function startWorker()
{
if(typeof(Worker)!=="undefined")
{
if(typeof(w)=="undefined")
{
w=new Worker("demo_workers.js");
}
w.onmessage = function (event) {
document.getElementById("result").innerHTML=event.data;
};
}
else
{
document.getElementById("result").innerHTML="Sorry, your browser does not support Web Workers...";
}
}

function stopWorker()
{ 
w.terminate();
}

*/