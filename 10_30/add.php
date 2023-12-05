<?php
	require("heading.php");
	// if submitted add EV else display form
 	if(isset($_POST['addButton']))
		addEV();
	else
		displayForm();
	require("footing.php");

function displayForm()
{
	echo <<<FORMBLOCK
		<form method="POST" action="add.php">
		<table>
			<tr>
				<th><label for="name">Model: </label></th>
				<th><label for="years">Years Produced: </label></th>
				<th><label for="range">Range: </label></th>
			</tr>

			<tr>
				<td><input type="text" id="name" name="name" required maxlength="64" placeholder="name of EV" autocomplete="off"></td>
				<td><input type="text" id="years" name="years" required maxlength="9" placeholder="1970-2000" pattern="^[0-9]{4}-$|[0-9]{4}-[0-9]{4}$" autocomplete="off"></td>
				<td><input type="text" id="range" name = "range" required maxlength="5" placeholder="999" pattern="^[0-9]{1-5}$" autocomplete="off"></td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="float:right"><input type="submit" name="addButton" value="Add EV"></td>
			</tr>
		</table>
		</form>
FORMBLOCK;
}	

function addEV()
{
	$name = $_POST['name'];
	$years = $_POST['years'];
	$range = $_POST['range'];

	$name = trim($name);
	$name = filter_var($name, FILTER_VALIDATE_REGEXP,
		array("options"=>array("regexp"=>"/^[0-9a-ZA-Z !-\.]{1,64}$/")));

	$years = trim($years);
	$years = filter_var($years, FILTER_VALIDATE_REGEXP,
		array('options'=>array('regexp'=>'/^[0-9]{4}-$|^[0-9]{4}-[0]9]{4}$/')));

	$range = trim($range);
	$range = filter_var($range, FILTER_VALIDATE_INT, 
		array('options'=>array('min_val'=>'1', 'max_val'=>'99999')));

	if ($name != false && $years != false && $range != false)
	{
		//connect to db
		require("credentials.php");
		$db = mysqli_connect($hostname, $username, $password, $database);

		if(mysqli_connect_errno())
			die("Unable to connect to database " . mysqli_connect_error());

		//create query the WRONG WAY (sql injection)
		$query = "INSERT INTO  cars (name, productionYears, miles) VALUES('" . $name . "','" . $years . "','" . $range . "')";

		//execute and display result
		if(mysqli_query($db, $query))
			echo <<<SUCCESSBLOCK
			<div class="center">
				<h2>Success! Record added to database.</h2>
			</div>
SUCCESSBLOCK;
		else
			echo <<<FAILBLOCK
			<div class="center">
				<h2>An error occured. Unable to add record.</h2>
			</div>
FAILBLOCK;
	} else {
		die("invalid inputs");
	}
}

?>
