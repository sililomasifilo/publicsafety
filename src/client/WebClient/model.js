/* 
    Main Application Model
*/

/* 
 * For prototyping, using tons of globals. not recommendeded for production.
 * 
 * Conventions used: 
 * 	1. Any GLOBAL is prefixed with "g"
 * 	2. camelCase
 * 	3. Descriptive variable names, no abbreviations.
 */
var gAlertFeedElement;
var gAlertMapElement;
var gUserAlertFeedElement;
var gLogInFormName;
var gNavBarName;

var gAlertsInfo;
var gUsersInfo;
var gUserData;
var gRefreshIntervalHandle;


function initializeModel() {
	gAlertsInfo = new Object();
	gAlertsInfo.lastUpdated = new Date();
	gAlertsInfo.alertsList = new Array();
	
	gUsersInfo = new Object();
	gUsersInfo.lastUpdated = new Date();
	gUsersInfo.usersList = new Object();
	
	gUserData = new Object();
	gUserData.myId = 0;
	gUserData.myInfo = new Object();
	gUserData.myAlerts = new Object();
	
}

function cleanupModel() {
	if (gRefreshIntervalHandle != undefined) {
		clearInterval(gRefreshIntervalHandle);
	}
}

function initializeUser() {
	// lookup cookie and if found, skip requiring a signin.
	// for now, do nothing.
}

function logIn(event) {
	event.preventDefault();
	var userEmail = $('#InputEmail').val();
	receiveLogInResponseFromServer("true");
	return false;
}

function receiveLogInResponseFromServer(response) {
	// if success, logged in view.
	$('#loginform').hide();
	$('.navbar').show();
	$('.tab-content').show();
	$('#userid a').show();
	
	gUserData.myId = "1";
	findUser("1");
    startModel();
	
    // if fail
}

function logOut(event) {
	event.preventDefault();
	/*
	 * clean up user info. throw away user info. 
	 * Note: There is no explicit signout needed.
	 */ 
	stopModel();
	
	// logged out  view
	$('#loginform').show();
	$('.navbar').hide();
	$('.tab-content').hide();
	$('#userid a').hide();	
}

function initializeView(feedElementName, mapElementName, userFeedElementName) {
    gAlertFeedElement = document.getElementById(feedElementName);
    gAlertMapElement = document.getElementById(mapElementName);	
	gUserAlertFeedElement = document.getElementById(userFeedElementName);
}

/*
 * Start any threads/actions needed to start functioning.
 * Typically invoked after the local user has been identified and logged in.
 */
function startModel() {
    refreshAlertsFeed();
}

function stopModel() {
	if (gRefreshIntervalHandle != undefined) {
		clearInterval(gRefreshIntervalHandle);
		gRefreshIntercalHandle = undefined;
	}
	// clean up global variables.
	gUserData.myId = "";
	updateLocalUserInfo();
	// TODO: call a helper method
	initializeModel();
}

function updateLocalUserInfo(userInfo) {
	gUserData.myInfo = userInfo;
	var userName = "";
	
	if (userInfo != undefined) {
		userName = userInfo["name"];
	}
    $('#userid p').html(userName);
}

function updateLocalUserAlerts(alertId, alert) {
	var userIdStr = ""+alert["user_id"];
	if (gUserData.myId == userIdStr) {
		gUserData.myAlerts[alertId + ""] = alert;		
	}

	var key;
	var feedhtml = "";
	for (key in gUserData.myAlerts) {
		feedhtml += alertHtmlView(gUserData.myAlerts[key]);
    	feedhtml +="<button class=\"btn btn-info\">Update</button>"

	}
	gUserAlertFeedElement.innerHTML = feedhtml;
}
/*
 * given userInfo from Server, add into the local cache of users
 */
function createOrUpdateUser(userid, userInfo) {

	if (userid == undefined) return 0;
	// convert to string if not already.
	var useridstr = "" + userid;
	var lcache = gUsersInfo.usersList[useridstr];
	
	// if this is local user data, update that as well.
	if (useridstr == gUserData.myId) {
		updateLocalUserInfo(userInfo);
	}
	
	if (lcache == undefined) {
		gUsersInfo.usersList[useridstr] = userInfo;
		return 1;
	}
	gUsersInfo.usersList[useridstr] = userInfo;
	return 0;
}

/*
 * lookup user in local cache.
 * TODO: if not found in local cache, reach out to server.
 */
function findUser(userid) {
	// first lookup in local cache.
	var user = gUsersInfo.usersList[(userid+"")];
	
	// if not found, GET from server.
	if (user == undefined) {
		try {
			getUserFromServer(receiveUserFromServer, userid);			
		} catch (err) {
			alert(err.toString());
		} 
	}
	return user;
}

function receiveUserFromServer(response) {
	var retVal = response["error"];
	if (retVal == "true") {
		return;
	}
	var userInfo = response["user"];
	createOrUpdateUser((userInfo["id"] + ""), userInfo);
}

function refreshAlertsFeed() {
    // get the alerts from server.
    getAlertsRecurring();
    // for auto-refresh, uncomment line below.
    //gRefreshIntervalHandle = setInterval(getAlertsRecurring, 1000);
}

function getAlertsRecurring() {
    // get the alerts from server.
    getAlerts(receiveAlertsFromServer);	
}
// handle info from the server.
function receiveAlertsFromServer(response) {	
	retVal = response["error"];

	// update global alerts model.
	gAlertsInfo.lastUpdated = new Date();
	// for now simply assign. Later do smarter updates.
	gAlertsInfo.alertsList = response["alerts"];
	
	// make one pass to load users.
	var alertArray = gAlertsInfo.alertsList;
    for (var i =0; i < alertArray.length; i++) {
    	var reporter = alertArray[i]["user"];
    	createOrUpdateUser(reporter["id"], reporter);
    	if (reporter["id"] == gUserData.myId) {
    		updateLocalUserAlerts(alertArray[i]["id"], alertArray[i]);
    	}
    }	

	paintAlertsView();
}

function paintAlertsView() {
    var feedhtml = "";
    var markerpositions = "";
    
    feedhtml = "Last Updated: " + gAlertsInfo.lastUpdated.toString();
    feedhtml += "<br><br><table class=\"table table-bordered\">";
    var alertArray = gAlertsInfo.alertsList;
    for (var i =0; i < alertArray.length; i++) {
    	var alertObj = alertArray[i];
    	
    	feedhtml +="<tr><td>";
    	feedhtml += alertHtmlView(alertObj);
    	
    	markerpositions += alertObj["latitude"]+","+alertObj["longitude"];
    	if (i!= (alertArray.length-1)) {
    		// add delimiter
    		markerpositions +="%7C";
    	}

    	feedhtml +="<button class=\"btn btn-info\">Respond</button>"
   	
    	feedhtml +="</td></tr>";
    }
    feedhtml += "</table>";
    
    // actually paint formatted html on page.
    gAlertFeedElement.innerHTML = feedhtml;
    
    var maphtml = '';
    
    maphtml = '<img src="http://maps.googleapis.com/maps/api/staticmap?zoom=13&size=400x400&markers=color:blue%7C'+
    	markerpositions + '&sensor=false" class="img-rounded">';
    
    gAlertMapElement.innerHTML = maphtml;
    return feedhtml;
}

/*
 * Paint one alert
 */
function alertHtmlView(alertObj) {
	var reporter = alertObj["user"];
	var feedhtml ="";
	feedhtml +=reporter["name"] + " : ";
	feedhtml += "<b>" + alertObj["type"] + "</b>, " + alertObj["message"];

	var alertEvents = alertObj["alert_event"];
	feedhtml+="<ul>";
	for (var j=0; j< alertEvents.length; j++) {
		var eventUser = findUser(alertEvents[j]["user_id"]);
		var username = alertEvents[j]["user_id"];
		if (eventUser != undefined) {
			username = eventUser["name"];
		}
		feedhtml +="<li>" + username +" : " +
			alertEvents[j]["message"] + "</li>";
	}
	
	feedhtml +="</ul>";
	return feedhtml;
}

/* 
 * Lets worry about refreshing automatically later 
 */
function refreshingfeed() {
    setInterval(getAlertsRecurring, 1000);
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