<?php

	require("heading.php");
	if(isset($_POST['deleteButton']))
		deleteEV();
	else
		displayForm();
	require("footing.php");

function displayForm(){
	//connect to db
	require("credentials.php");
	
	$db = mysqli_connect($hostname, $username, $password, $database);

	if(!$db) {
		die("Unable to connect to database " . mysqli_error());
	}



	echo <<<FORMBLOCK
		<form method="POST" action="delete.php">
		<table>
			<tr>
				<th>Delete</th>
				<th>Name</th>
				<th>Production Years</th>
				<th>Range</th>
			<tr>
FORMBLOCK;
	$cars = mysqli_query($db, 'SELECT name, productionYears, miles, ID from cars ORDER BY productionYears');

	if(!$cars) {
		die("Query failed" . mysqli_error());
	}

	while($row = mysqli_fetch_array($cars)){
		$name=$row[0];
		$prodYears = $row[1];
		$range = $row[2];
		$ID = $row[3];
		if($background++ %2 == 0)
			echo"		<tr style=\"background-color: white\">\n";
		else	
			echo"		<tr style=\"background-color: lightgray\">\n";
		echo <<<TABLEDATA
			<td><input type="checkbox" value='{$ID}' name="selectedEv"></td>
			<td>$name</td>
			<td>$prodYears</td>
			<td>$range</td>
		</tr>
TABLEDATA;
	}
	
	echo "		</table>";
	echo "	<input type=\"submit\" name=\"deleteButton\" value=\"Delete EV\">";
	echo " </form>";
	mysqli_close($db);
}
function deleteEV(){
	echo "DELETE EV COMING SOON!";
	$ID = $_POST['selectedEv'];

	require("credentials.php");
	$db = mysqli_connect($hostname, $username, $password, $database);
	if(mysqli_connect_errno())
		die("Unable to connect to the database " . mysqli_connect_error());

	$query = mysqli_prepare($db, "DELETE FROM cars WHERE ID=?");

	mysqli_stmt_bind_param($query, 'i', $ID);

	if(mysqli_stmt_execute($query))
	{
		echo <<<SUCCESSBLOCK
		<div class="center">
			<h2>Success! Record Deleted!<h2>
		</div>
SUCCESSBLOCK;
	} else
	{
		echo "Error executing statement: " . mysqli_stmt_error($query);
		echo "Error details: " . musqli_error($db);

		echo <<<FAILBLOCK
		<div class="center">
			<h2>An error occured. Unable to delete record.</h2>
		</div>
FAILBLOCK;
	}
}
?>
