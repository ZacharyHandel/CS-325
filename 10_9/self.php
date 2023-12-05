<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// get the form data
		$email = $_POST['email'];
		// validate the form data
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		// if not valid, display error message
		if (!$email)
			die("CRINGE!!!!!!!! BAD INPUT");
		else
			send_response($email);
		// else process data and display result	
	} else {
		//THIS IS ASSUMING A GET REQUEST
		//dislay empty form
		send_form($_SERVER['PHP_SELF']);
	}


// ----------------------------------------------------------------------------------------------------
function send_response($email) {
	send_header();
	echo "<p style=\"text-align: center;\">\n$email\n</p>\n";
	send_trailer();
}

//----------------------------------------------------------------------------------------------------
function send_form($action) {
	send_header();

	echo <<<SHOW_FORM

		<form method="POST" action="$action">
			<label for="email">Email address: </label>
			<input type="email" id="email" name="email" required>
			<br>
			<button type="submit">Submit</button>
		</form>

SHOW_FORM;
	send_trailer();
}
// -------------------------------------------------------------------------------------------------------
function send_header() {
	echo <<<HEADR
<!DOCTYPE html>
<html lang="en">
<head>
	<title>PHP Form - Submit to Self</title>
	<meta charste="UTF-8">
	<link rel="stylesheet" href="self.css">
</head>
<body>
	<div class="center">
		<h1>Submit to Self</h1>
HEADR;
}

// -------------------------------------------------------------------------------------------------------
function send_trailer() {
	echo <<<TRAILER
	</div>
</body>
</html>
TRAILER;
}
?>
