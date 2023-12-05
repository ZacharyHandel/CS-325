<?php
#CONNECT TO DB
require("credentials.php");
$db = mysqli_connect($hostname, $username, $password, $database);

if (mysqli_connect_errno()) {
    die("Unable to connect to the database: " . mysqli_connect_error());
}

#MAIN BLOCK
require("heading.php");
if(isset($_POST['editButton']))
{
	editEV();
}
elseif(isset($_POST['selectedEv']))
{
	editSelected();
}
else
{
	displaySelect();
}
require("footing.php");
#END MAIN BLOCK


#################################FUNCTIONS##########################################
function displaySelect()
{
    global $db; // Make $db accessible inside the function

    echo <<<STARTFORMBLOCK
    <form method="POST" action="update.php">
        <label for="ev">Select an EV to edit:</label>
        <select name="selectedEv" id="ev">
STARTFORMBLOCK;

    $cars = mysqli_query($db, "SELECT name, ID FROM cars ORDER BY name");

    if(!$cars) {
	die("Query failed." . mysqli_error());
    }

    while ($row = mysqli_fetch_array($cars)) {
	$name = $row[0];
	$ID = $row[1];
    	echo "<option value='{$ID}'>{$name}</option>";
    }

    echo <<<ENDFORMBLOCK
        </select>
        <input type="submit" name="selectUpdate" value="Update Selected">
    </form>
ENDFORMBLOCK;
}

function editSelected()
{	
	$selectedEv = $_POST['selectedEv'];
	global $db;
	$query = mysqli_prepare($db, "SELECT name,productionYears,miles FROM cars WHERE ID=?");
	mysqli_stmt_bind_param($query, "i", $selectedEv);

	if(!mysqli_stmt_execute($query))
		die("Error executing query " . $mysqli_stmt_error());
	
	mysqli_stmt_bind_result($query, $name, $years, $miles);
	mysqli_stmt_fetch($query);
	mysqli_stmt_close($query);
	echo <<<FORMBLOCK
	<form method="POST" action="update.php">
	<table>
		<tr>
			<th><label for="name">Model: </label></th>
			<th><label for="years">Years Produced: </label></th>
			<th><label for="range">Range: </label></th>
		</tr>
			<td><input type="text" id="updatedName" name="updatedName" required maxlength="64" value="{$name}" autocomplete="off"></td>
			<td><input type="text" id="updatedYears" name="updatedYears" required maxlength="64" value="{$years}" autocomplete="off"></td>
			<td><input type="text" id="updatedMiles" name="updatedMiles" required maxlength="64" value="{$miles}" autocomplete="off"></td>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="float:right;"><input type="submit" name="editButton" value="Update EV"></td>
		</tr>
	</table>
	</form>
FORMBLOCK;

}

function editEV(){
	global $db;
	$updatedName = $_POST['updatedName'];
	$updatedYears = $_POST['updatedYears'];
	$updatedMiles = $_POST['updatedMiles'];
	$selectedEv = $_POST['selectedEv'];
	$query = mysqli_prepare($db, "UPDATE cars SET name=?, productionYears=?, miles=? WHERE ID=?");
	mysqli_stmt_bind_param($query, 'sssi', $updatedName, $updatedYears, $updatedMiles, $selectedEv);

	if(mysqli_stmt_execute($query))
	{	
		echo $selectedEv;
		echo <<<SUCCESSBLOCK
		<div class="center">
			<h2>Success! Record edited.</h2>
		</div>
SUCCESSBLOCK;
	} else
	{
		echo "Error executing statement: " . mysqli_stmt_error($query);
		echo "Error details: " . mysqli_error($db);

		echo <<<FAILBLOCK
		<div class="center">
			<h2>An error occured. Unable to add record.</h2>
		</div>
FAILBLOCK;
	}
}
##################END FUNCTIONS#################################

#CLOSE DB CONNECTION
mysqli_close($db);
?>
