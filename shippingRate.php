<?php include "session.php"; ?>
<?php 
/*
*shippingRate.php
*Sets the shipping variable to the correct price depending on the users selection of the radio button.
*/

header("location: checkout.php");

$price = 0;

switch ( $_POST['shipping'])
{

	case('regular'):
		$_SESSION['shipping'] = 4.99;
		break;
	case('expedited'):
		$_SESSION['shipping'] = 9.99;
		break;
	case('overnight'):
		$_SESSION['shipping'] = 24.99;
		break;
}

	$_SESSION['progress'] = 75;

?>