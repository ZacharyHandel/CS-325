<?php
	//ASK THE CLIENT TO SAVE A COOKIE****** Correct spot
	//lastvisit=todays date (10-16-2023)
	//include head.php
	//if this is the first visit
		//ask the client to save a cookie**** THIS IS WRONG PLACE TO PUT IT BECAUSE response headers must be before content. PHP will know this when we start sending output
		//display a welcome message
	//else if this is a repeat fisit
		//display a welcome back message with the date of the last visit
	//include foot.php

	$today = date('m-d-Y');
	setcookie('lastvisit', $today, time() + (365 * 24 * 60 * 60), '/');

	require("head.php");
	if (array_key_exists('lastvisit', $_COOKIE)) {
		print "Nice to see you again.";
		print "Your last visit was on " . $_COOKIE['lastvisit'];	
	}
	else
		print "Welcome. Enjoy the site";

	require("foot.php");
?>
