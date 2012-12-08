<?php include "session.php"; ?>
<?php 

header("location: checkout.php");

$curU = $_SESSION['accountId'];
$_SESSION['progress'] =  25;

$labels = array("name", "number", "date", "code");
$minimum = array(2, 16, 4, 3); 



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

if(strlen($_POST[$labels[2]]) >= $minimum[2] and count(explode("/", $_POST[$labels[2]])) == 2)
{	
	

	
	$_SESSION["credit".$labels[2]] = $_POST[$labels[2]];
	$_SESSION['progress'] +=  5;
}

if(strlen($_POST[$labels[3]]) == $minimum[3] and is_numeric($_POST[$labels[3]]))
{
	
	$_SESSION["credit".$labels[3]] = $_POST[$labels[3]];
	$_SESSION['progress'] +=  5;
}

?>