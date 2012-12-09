<?php include "session.php"; ?>
<?php 
/*
*checkPayment.php
*error checks the payment fields
*/

//redirect
header("location: checkout.php");

//passed in variables
$curU = $_SESSION['accountId'];
$_SESSION['progress'] =  25;

//variables
$labels = array("name", "number", "date", "code");
$minimum = array(2, 16, 4, 3); 

/*
checks if name, number, date, and code are all within their limits.
if so, store them. increment progress per succesful field.
*/

if( strlen( $_POST[$labels[0]] ) >= $minimum[0] and count(explode(" ", $_POST[$labels[0]])) >= 2)
{
	
	$_SESSION["credit".$labels[0]] = $_POST[$labels[0]];
	$_SESSION['progress'] +=  5;
}

if(strlen($_POST[$labels[1]]) == $minimum[1] and is_numeric($_POST[$labels[1]]))
{
	
	$_SESSION["credit".$labels[1]] = $_POST[$labels[1]];
	$_SESSION['progress'] +=  5;
}

if(strlen($_POST[$labels[2]]) >= $minimum[2] and strlen($_POST[$labels[2]]) <= 5 and count(explode("/", $_POST[$labels[2]])) == 2)
{	
	
	$a = explode("/", $_POST[$labels[2]]);
	
	if(is_numeric($a[0]) and is_numeric($a[1]))
	{
		$_SESSION["credit".$labels[2]] = $_POST[$labels[2]];
		$_SESSION['progress'] +=  5;
	}
}
else
{
	$_SESSION["credit".$labels[2]] ="";

}

if(strlen($_POST[$labels[3]]) == $minimum[3] and is_numeric($_POST[$labels[3]]))
{
	
	$_SESSION["credit".$labels[3]] = $_POST[$labels[3]];
	$_SESSION['progress'] +=  5;
}

?>