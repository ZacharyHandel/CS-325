<?php
	session_start();
	require("head.php");

	if(array_key_exists('lastvisit', $_SESSION)) {
		print "Your last visit was on " . $_SESSION['lastvisit'] . '<br>';
		print 'You have visited' . $_SESSION['visits'] . ' times.<br>';
		print 'The browser you used last time was ' . $_SESSION['browser'];
	} else {
		print "Welcome";
		$_SESSION['visits'] = 0;
	}

	$_SESSION['lastvisit'] = date('m-d-Y');
	$_SESSION['visits'] += 1;
	$_SESSION['browser'] = $_SERVER['HTTP_USER_AGENT'];

	require("foot.php");
?>
