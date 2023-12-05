<?php
	require("heading.php");

	echo <<<HTMLBLOCK
		<table>
			<tr>
				<td>&bullet; <a href="listing.php">Display EV List</a></td>
			</tr>
			<tr>
				<td>&bullet; <a href="add_prepared.php">Add EV</a></td>
			</tr>
			<tr>
				<td>&bullet; <a href="update.php">Edit EV</a></td>
			</tr>
			<tr>
				<td>&bullet; <a href="delete.php">Delete EV</a></td>
			</tr>
		</table>
HTMLBLOCK;

	require("footing.php");
?>
