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
		<form method="POST" action="add_prepared.php">
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

	//values are there before filter
	$name = trim($name);
	//echo "name after trim: " . $name;
	$name = filter_var($name, FILTER_VALIDATE_REGEXP, 
		array("options"=>array("regexp"=>"/^[0-9a-zA-Z !-\.]{1,64}$/")));
	//echo "name after filter: " . $name;

	$years = trim($years);
	//echo "years after trim: " . $years;
	$years = filter_var($years, FILTER_VALIDATE_REGEXP, 
		array('options'=>array('regexp'=>'/^[0-9]{4}-$|^[0-9]{4}-[0-9]{4}$/')));
	//echo "years after filter: " . $years;
	
	$range = trim($range);
	//echo "range after trim: " . $range;
	$range = filter_var($range, FILTER_VALIDATE_INT, 
		array('options'=>array('min_val'=>'1', 'max_val'=>'99999')));
	//echo "range after filter: " . $range;
	if ($name != false && $years != false && $range != false)
    {
        // connect to db
        require("credentials.php");
        $db = mysqli_connect($hostname, $username, $password, $database);
        if(mysqli_connect_errno())
            die("Unable to connect to database " . mysqli_connect_error());

        // create query designed to avoid SQL Injection
        $query = mysqli_prepare($db, "INSERT INTO cars (name, productionYears, miles) VALUES(?, ?, ?)");

        // bind parameters
        mysqli_stmt_bind_param($query, 'sss', $name, $years, $range);

        // execute and display result
        if(mysqli_stmt_execute($query))
        {
            echo <<<SUCCESSBLOCK
            <div class="center">
                <h2>Success! Record added to database.</h2>
            </div>
SUCCESSBLOCK;
        }
        else
        {
            // Capture and display the error
            echo "Error executing statement: " . mysqli_stmt_error($query);
            echo "Error details: " . mysqli_error($db);

            echo <<<FAILBLOCK
            <div class="center">
                <h2>An error occurred. Unable to add record.</h2>
            </div>
FAILBLOCK;
        }

        // close the statement
        mysqli_stmt_close($query);

        // close the database connection
        mysqli_close($db);
    }
    else
    {
        die("Invalid inputs");
    }
}

?>
