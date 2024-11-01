<?php

if ( !defined( 'ABSPATH' ) ) {
    // Prevent direct access to this file.
    header( 'HTTP/1.0 403 Forbidden' );
    echo 'This file should not be accessed directly NOW PLEASE GO AWAY!';
    exit;
}
// Exit if accessed directly
$checkdata = esc_html( get_option( 'zipcodes1' ) );
include zipcheckdata;
//check user data for errors
update_option( 'zipcodes1', $checkdata );
$checkdata = esc_html( get_option( 'zipcodes2' ) );
include zipcheckdata;
//check user data for errors
update_option( 'zipcodes2', $checkdata );
$zipcodeswon = explode( "\n", esc_html( get_option( 'zipcodeswon' ) ) );
// put zips in array
$zipcodeswon = array_reverse( $zipcodeswon );
//reverse for viewing
$zipcodeswon = implode( "\n", $zipcodeswon );
// put zips in string
$zipcodeslost = explode( "\n", esc_html( get_option( 'zipcodeslost' ) ) );
// put zips in array
$zipcodeslost = array_reverse( $zipcodeslost );
//reverse for viewing
$zipcodeslost = implode( "\n", $zipcodeslost );
// put zips in string
add_filter( 'upload_dir', 'zipcode_redirect' );
?>
	
	
	
	<h1>Zip Code Redirect</h1>
<button class="tablink" onclick="openPage('Settings')" id="defaultOpen">Settings</button>

<button class="tablink" onclick="openPage('Instructions')">Instructions</button>

<div id="Settings" class="tabcontent">  
  <form method="post" action="options.php">
  
<?php 
settings_fields( 'zipcode_redirect_settings' );
?>

<div class="w3-container">

					<h3>1.) Select Which  Zip Code System To Use</h3>
					
<h4><input type="radio" id="7digit" name="zipcodescheck" value="7"<?php 
if ( get_option( 'zipcodescheck' ) == '7' ) {
    echo 'checked="checked"';
}
?>> 5, 6, Or 7 Digit "UK" Style System.					
&emsp;					
<input type="radio" id="4digit" name="zipcodescheck" value="4"<?php 
if ( get_option( 'zipcodescheck' ) == '4' ) {
    echo 'checked="checked"';
}
?>> Four (4) Digit "Swiss" Style System.</h4>

<h4><input type="radio" id="5digit" name="zipcodescheck" value="5"<?php 
if ( get_option( 'zipcodescheck' ) == '5' ) {
    echo 'checked="checked"';
}
?>> Five (5) Digit "American" Style System.
&emsp;
<input type="radio" id="6digit" name="zipcodescheck" value="6"<?php 
if ( get_option( 'zipcodescheck' ) == '6' ) {
    echo 'checked="checked"';
}
?>> Six (6) Digit "Canadian" Style System.</h4>

</div>
<div class="w3-container">

					<h3>2.) Now Select Whether To Use A Submit Button </h3>
		
 <h4>Use A Submit Button <input type="checkbox" name="zipsubmitcheck" id="zipsubmitcheck" <?php 
if ( get_option( 'zipsubmitcheck' ) == 'on' ) {
    echo "checked";
}
?>></h4>	

</div>

<div class="w3-container">
<h3>3.) Then Create Messages For The Plugin To Use</h3>
<div class="zcr-third zcr-container">

<h4>Message Asking User To Enter</h4>  
<h1><textarea name = "zipcodesask" id = "zipcodesask" rows = "2" cols = "30" maxlength = "100" >
<?php 
esc_html_e( get_option( 'zipcodesask' ) );
?></textarea></h1>
<h4>Their Full Zip code</h4>

</div>

<div class="zcr-third zcr-container">


<h4>Message Asking User To Use The</h4>
<h1><textarea name="zipcodesuse" id = "zipcodesuse" rows="2" cols="30" maxlength="100" ><?php 
esc_html_e( get_option( 'zipcodesuse' ) );
?></textarea></h1>
<h4> Four, Five, Six Or UK Zip Code System</h4>

</div>

<div class="zcr-third zcr-container">

<h4>Message Asking User To Wait</h4>  
<h1><textarea name = "zipcodeswait" id = "zipcodeswait" rows = "2" cols = "30" maxlength = "100" ><?php 
esc_html_e( get_option( 'zipcodeswait' ) );
?></textarea></h1>
<h4>While Their Zip Code Is Checked</h4>

</div> </div> 

<div class="w3-container">

<div class="zcr-half zcr-container">

<h4>Message Saying Zip Code</h4>  
<h1><textarea name = "zipcodeswrong" id = "zipcodeswrong" rows = "2" cols = "40" maxlength = "100" ><?php 
esc_html_e( get_option( 'zipcodeswrong' ) );
?></textarea></h1>
<h4>Is Not The Correct Format</h4>

</div> 

 <div class="zcr-half zcr-container">
 
 
<h4>Message Saying Zip Code Cannot </h4>
<h1><textarea name="zipcodesneg" id = "zipcodesneg" rows="2" cols="40" maxlength="100" ><?php 
esc_html_e( get_option( 'zipcodesneg' ) );
?></textarea></h1>
<h4>Be Redirected Or A Default URL</h4>

</div></div>

<div class="w3-container">

<div class="zcr-third zcr-container">

<h4>Input Box Text</h4>  
<h1><textarea name = "zipplaceholder" id = "zipplaceholder" rows = "2" cols = "30" maxlength = "100" >
<?php 
esc_html_e( get_option( 'zipplaceholder' ) );
?></textarea></h1>

</div>

<div class="zcr-third zcr-container">

<h4>Input Box Help Text</h4>
<h1><textarea name="ziptitle" id = "ziptitle" rows="2" cols="30" maxlength="100" ><?php 
esc_html_e( get_option( 'ziptitle' ) );
?></textarea></h1>

</div>

<div class="zcr-third zcr-container">

<h4>Submit Button Text</h4>  
<h1><textarea name = "zipsubmittext" id = "zipsubmittext" rows = "2" cols = "30" maxlength = "100" ><?php 
esc_html_e( get_option( 'zipsubmittext' ) );
?></textarea></h1>

</div> </div> 

<h3>4.) Input Your URLs Or Messages And Zip Code Data </h3>
<div class="w3-container">

<div class="zcr-half zcr-container">

<h4>Redirect URL & Zip Codes.</h4>
<h1><textarea name = "zipcodes1" id = "zipcodes1" rows = "3" cols = "72"><?php 
esc_html_e( get_option( 'zipcodes1' ) );
?></textarea></h1>
<h4>Separate Each Entry With A Space.</h4>
</div>

<div class="zcr-half zcr-container">

<h4>Redirect URL & Zip Codes.</h4>
<h1><textarea name = "zipcodes2" id = "zipcodes2" rows = "3" cols = "72"><?php 
esc_html_e( get_option( 'zipcodes2' ) );
?></textarea></h1>
<h4>Separate Each Entry With A Space.</h4>
</div>

</div>


<?php 
?>

<h3><input type="submit" value = "Save Settings"></h3></form>

	<h3>5.) Finally Put The Shortcode [zipcoderedirect] and/or [zipcoderedirectplus] On Your Webpage</h3>
	
  <div class="w3-container">

<div class="zcr-half zcr-container">

<h4>Last Ten Re-directed Zip Codes </h4>
<h1><textarea rows = "5" cols = "64" readonly><?php 
esc_html_e( $zipcodeswon );
?></textarea></h1>

</div>

<div class="zcr-half zcr-container">

<h4>Last Ten Non Re-directed Zip Codes </h4>
<h1><textarea rows = "5" cols = "64" readonly><?php 
esc_html_e( $zipcodeslost );
?></textarea></h1>

</div>

</div>

<h4>The Last Zip Code Query Took <?php 
esc_html_e( get_option( 'zipcodestime' ) );
?> Seconds To Execute</h4>
<h3><a href="<?php 
echo wp_upload_dir()['url'] . '/ZipCodes.docx';
?>"> Download All 1000 Outward Zipcodes </a> </h3>
<h3><a href="<?php 
echo wp_upload_dir()['url'] . '/PostCodes.docx';
?>"> Download All 2981 UK Outward Postcodes </a> </h3>
<?php 
if ( !function_exists( 'get_plugins' ) ) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}
$all_plugins = get_plugins();
foreach ( $all_plugins as $plugin => $plugin_data ) {
    $cache = stripos( $plugin_data['Name'], "cache" );
    if ( is_numeric( $cache ) ) {
        echo "<h3> Warning </h3><h4>It Appears That You Are A Using Caching/Optimization Plugin.<br> \r\nThis Type Of Plugin Can Stop Zipcode Redirect From Working Correctly.<br>\r\nPlease Be Aware Of This And Exempt Zipcode Redirect If Necessary.";
        break;
    }
}
?>


</h4>
</div>


<div id="Instructions" class="tabcontent">

<h3>Instructions For Use.</h3>

<h5>
 First and foremost, select which zip code system to use, the UK system, the Canadian system, the 4 digit Swiss style system or the 5 digit American style system.<br>
	Next, select whether to use a submit button or not.<br>
	Now, you can set your user messages, leave the message blank if you don’t want to use that particular message.<br>
	If you want to use a default URL for users, not matching any of your zip codes, just put the URL only, in the "cannot be redirected" text box.<br>
	<b>Example 1 : http://www.example.com </b><br>
	Want to use your user's zip code in your "please wait", "correct format", or "cannot be redirected" messages.<br> 
	Insert "user input" where you want the zip code to appear, in the appropriate message.<br>
	<b>Example 2: Please Wait While We Check The Zip Code user input.</b><br>
	Now, input your URLs, messages and zip codes.<br>
	If you want to display a message instead of using a redirection, you must separate your message and zip codes with a hyphen (-).<br>
	<b>Example 3 : http://www.example.com 001 002 003 004 005 etc.</b><br>
	<b>Example 4 : Great News We Cover user input Please Phone 1 800 XXX - 001 002 003 004 005 etc.</b><br>
	<b>Example 5 : Great News We Cover Your Area. Please Phone 1 800 XXX - 001 002 003 004 005 etc.</b><br>
	Put a redirect URL or message, initially, in the first text box, followed by the zip codes you want to associate with that URL, separated by a space.<br>
	Fill each textbox with data as needed. You can put unlimited zip codes in each text box.<br>
	In the unlimited version, put each redirected URL or message with associated zip codes, on a separate individual line.<br>
	<b>You Can Use URLs Or Messages On Each Individual Line</b><br>
	Now, put the short codes [zipcoderedirect] and/or [zipcoderedirectplus] anywhere you want on your webpage including sidebars.</h5>
	<h3>How Does The Plugin Work.</h3> 
	<h5>First of all the plugin creates an input box on your webpage, populated with messages you have set.<br>
	When a user inputs a zip code and then presses the enter key, submit button (if activated) or the zip code input box loses focus, a JavaScript function is triggered, sending the user input to your server via AJAX.<br>
	A zipcode check function is initiated to authenticate the user input.<br>
	The zipcode check function is a tool that allows you to verify if a given zipcode is valid or not. It helps to prevent errors that can occur when entering incorrect information. The tool checks the format of the code to ensure the zip code has the correct number of digits and is alpha-numeric.<br> 
	<b>Overall, the zipcode check function is a simple yet essential tool for ensuring the accuracy of information.</b><br>
	If the user's zip code does not pass the zipcode check function, the "try again" message is displayed.<br>
	If the user's zip code passes these checks, the user's zip code is then checked with the zip codes you have previously entered.<br>
	Starting with zip codes in the first text box, onto the second text box, then third, then fourth, through to the unlimited text box in that order.<br>
	It helps to put your most redirected URLs in the first text boxes etc.<br>
	If the zip codes match the user is automatically redirected to the relevent webpage or a default message is dispalyed.<br>
	We have put a timer in the software to give you the heads up on how fast your server is dealing with the zip code queries.<br>
	The timer starts when the AJAX request is fired and ends when the server returns a response.<br>
	The last zip code query took <?php 
esc_html_e( get_option( 'zipcodestime' ) );
?> seconds to execute.<br>
	We recommend you put the Zip Code Redirect in a sidebar or maybe a banner.<br>
	You can have two instances of the plugin on a webpage. Use the shortcodes [zipcoderedirect] and/or [zipcoderedirectplus] anywhere you want on your webpage including sidebars.<br>
	You can use multiple instances of the short codes across your website but only one of each short code on any webpage.<br>
	Be aware of webpage content movement when the Zip Code Redirect shortcodes are used, and place the short code accordingly.<br>
	Want to add your CSS. Just open plugins/zipcode-redirect/css/style.css in your favorite editor. Add your CSS and save.<br>
	Alternatively copy the code below and save it to your themes additional CSS settings.<br>
	Get creative, jazz up those input boxes, you can now alter and play with the plugin CSS from there.<br>

	<br>
	.zipcodetext {<br>
		/* Css for message text */<br>
		font-size: 18px;<br>
	}<br>
	input[type=text]{<br>
		/* Css for the form text box*/<br>
		background-color: silver;<br>
	}<br>
	input[type=text]:focus {<br>
		/* Css for the input when form text box gets focus*/<br>
		background-color: silver;<br>
	}<br>
	input[type=submit] {<br>
		/* Css for the submit button */<br>
		font-size: 18px;<br>
	}<br>
	<br>
	Unlimited zip codes can be redirected to Unlimited Urls using Zipcode Redirect<br></h5>
	
	
<?php 
remove_filter( 'upload_dir', 'zipcode_redirect' );
?>
	<h4>Technical Information</h4> 
	<h5>
	Zipcode Redirect was developed on a default 6.6 Wordpress installation running the free Astra theme Version: Version: 4.8.0 PHP version 8.0.26.
	</h5>
	
	</div>
	
	