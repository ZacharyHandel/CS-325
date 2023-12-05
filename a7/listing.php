<?php
	require("heading.php");
	displayList();
	require("footing.php");
//---------------------------------------------
function displayList()
{
	$background = 0;
	echo <<<HTMLBLOCK
		<table>
			<tr>
				<th>Name</th>
				<th>Production Years</th>

				<th>Range</th>
			<tr>

HTMLBLOCK;	

	//connect to db (name machine, username, and password). There are different functions depending on the db
	
	require("credentials.php");

	$db = mysqli_connect($hostname, $username, $password, $database);
	if(!$db) {
		die("Unable to connect to database " . mysqli_error());
	}

	//build query and execute
	$cars = mysqli_query($db, 'SELECT name,productionYears,miles FROM cars ORDER BY productionYears');

	if(!$cars) {
		die("Query failed" . mysqli_error());
	}

	//iterate over the result (rowset)
	while($row = mysqli_fetch_array($cars))
	{
		$name = $row[0];
		$prodYears = $row[1];
		$range = $row[2];

		if($background++ %2 == 0)
			echo"		<tr style=\"background-color: white\">\n";
		else
			echo"		<tr style=\"background-color: lightgray\">\n";	
		echo <<<TABLEDATA
			<td>$name</td>
			<td>$prodYears</td>
			<td>$range</td>
		</tr>
TABLEDATA;		
	}

	echo "		</table>";
	mysqli_close($db);
}
?>





