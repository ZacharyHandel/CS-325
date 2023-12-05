<?php

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$bet = $_POST['bet'];
		$bet = filter_var($bet, FILTER_VALIDATE_FLOAT);
		if(!$bet)
			die("Error: Please input a decimal value.");
		else
			process_form($bet);
	} else {
		display_page($_SERVER['PHP_SELF']);
	}
//FUNCTIONS-------------------------------------------------------------------
function head() {
	echo<<<HEADR
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Slot Machine Assignment (A4)</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="slot.css">
</head>
<body>
	<div class="center">
		<h1>***Slot Machine Simulator***<h1>
HEADR;
}

function display_page($action) {
	head();
	
	echo<<<SHOW_FORM
		<form id="submit-form" method="POST" action="$action">
			<label for="bet">Amount of bet: </label>
			<input type="number" id="bet" name="bet" min="0" max="1000.01" step="1" placeholder="nnnn" required>
			<button type="submit">Play</button>
			<br><br><br>
		</form>
SHOW_FORM;	
	foot();
}

function process_form($bet) {
	$item1 = generate_item();
	$item2 = generate_item();
	$item3 = generate_item();

	if($item1 == $item2 && $item1 == $item3) {
		$prize = $bet * 3;
	} elseif ($item1 == $item2 || $item1 == $item3 || $item2 == $item3) {
		$prize = $bet * 2;
	} else{
		$prize = 0;
	}

	head();
	if($prize > 0)
	{
		echo<<<PROCESSEDWIN
			<p>WIN!</p>
			<div class="result">Prize: \$$prize</div>
			<div class="items-display">
				<div class="item">$item1</div>
				<div class="item">$item2</div>
				<div class="item">$item3</div>
			</div>
			<a id="play-again" href="/~zahand/cs325/a5/slot.php">PLAY AGAIN</a>
			<br>
			<a id="play-again" href="https://youtu.be/dQw4w9WgXcQ?si=j5cMMWeO7TOGzMdj">Click for FREE PRIZE!</a>
	
	PROCESSEDWIN;
	} else {
		echo<<<PROCESSEDLOSE
			<p>Lose.</p>
			<div class="result">Prize: \$$prize</div>
			<div class="items-display">
				<div class="item">$item1</div>
				<div class="item">$item2</div>
				<div class="item">$item3</div>
			</div>
			<a id="play-again" href="/~zahand/cs325/a5/slot.php">PLAY AGAIN</a>
			<br>
			<a id="play-again" href="https://youtu.be/dQw4w9WgXcQ?si=j5cMMWeO7TOGzMdj">Click for FREE PRIZE!</a>
	
	PROCESSEDLOSE;	
	}
	foot();
}

function foot() {
	echo<<<FOOT
		<div class="tag">
			<p>Slot machine simulator © Zachary Handel 2023<p>
		</div>
	</div>
	<script src="slot.js"></script>
</body>
</html>
FOOT;
}

function generate_item() {
	$items = array("Cherries","Oranges","Plums","Bells","Melons","Bars");
	$generated_item = $items[random_int(0,5)];

	return $generated_item;
}
?>

