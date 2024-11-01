function zipajax_plus() {
if ( document.forms.zipplus.ziptextplus.value === "") {
document.getElementById("zipplusshow").innerHTML = (ziplisten_vars.zipuse);return ;}
var zipcode = document.forms.zipplus.ziptextplus.value.toUpperCase(); //uppercase user input
var zipwait = ziplisten_vars.zipwait;if (zipwait ===""){ document.getElementById("zipplusshow").innerHTML = "";}else if (zipwait.search("user input") >= 0){zipwait = zipwait.substring(0, zipwait.search("user input")) + zipcode + zipwait.substring(zipwait.search("user input") + 10);document.getElementById("zipplusshow").innerHTML = (zipwait);}else {document.getElementById("zipplusshow").innerHTML = (zipwait);}//construct final message
var data = {
'action'   : 'zipredirect_ajax_call', // the name of the PHP function we are calling!
'userzip' : document.forms.zipplus.ziptextplus.value , //value to send to function
'security' : ziplisten_vars.security};
jQuery.post(ziplisten_vars.ajaxurl, data, function(response) { // send data and respond
switch(response) {// act on the final response
case "1":
response = ziplisten_vars.zipwrong;
if (response.search("user input") >= 0) {
response = response.substring(0, response.search("user input")) + zipcode + response.substring(response.search("user input") + 10);}//constuct final message
document.getElementById("zipplusshow").innerHTML = (response); // display final message
break;
case "2":
response = ziplisten_vars.zipneg;
if (check = /http/.test(response)) {window.location.href = (response);}//if response is a url redirect to the final url
if (response.search("user input") >= 0){ response = response.substring(0, response.search("user input")) + zipcode + response.substring(response.search("user input") + 10);} 
document.getElementById("zipplusshow").innerHTML = (response);// display final message
break;
default:
if (/http/.test(response) ) {window.location.href = (response);// redirect to the final urls
document.forms.zipplus.ziptextplus.value = "";}//reset form value
else if (response.search("user input") >= 0){ response = response.substring(0, response.search("user input")) + zipcode + response.substring(response.search("user input") + 10);
document.getElementById("zipplusshow").innerHTML = (response); }// display final message
else {document.getElementById("zipplusshow").innerHTML = (response); }
}})}	