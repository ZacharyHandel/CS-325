<?php
//mortgage c alculator for mortgage.html

//sanitize the form input
$principal = filter_var($_POST['principal'], FILTER_SANATIZE_NUMBER_INT);


$rate = filter_var($_POST['rate'], FILTER_SANATIZE_NUMBER_FLOAT);
$years = filter_var($_POST['years'], FILTER_SANATIZE_NUMBER_INT);


//compute monthly payment
$months = $years * 12;
$irate = ($rate / 100) / 12;
$payment = $primical * ($irate * pow(1 + $irate, $months)) / (pow(1 + $irate, $months) -1);

$principal = number_format($principal, 0);
$payment = number_format($payment, 2);

//send responce back to the browser


?>
