<?php include "session.php"; ?>
<?php 

/*
*useAddress.php
*autofills the address session variables with the ones stored in the DB
*/

//redirect
header("location: checkout.php");

//passed in variable
$curU = $_SESSION['accountId'];
$_SESSION['progress'] =  0;

$labels = array(	"Name", 
			"Address", 
			"City", 
			"State", 
			"Zip", 
			"Phone", 
			"Name on Card", 
			"Number", 
			"Date", 
			"Code");

$con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
$rs = mysql_select_db("clargr1", $con) or die("Could not connect select $db database");
$query = "";
$row = array();

$query = ("SELECT first_name, last_name, shipping_address, shipping_city, shipping_state, shipping_zip,  billing_address, billing_city, billing_state, billing_zip,  phone FROM `accounts` WHERE id =" . $curU );
$result = mysql_query($query, $con) or die("Could not execute query '$query'");
$row = mysql_fetch_array($result);


/*
Set shipping and billing info stored into the session varriables
*/



$_SESSION["shipping".$labels[0]] = $row[0] . " " . $row[1];
$_SESSION["billing".$labels[0]] =  $row[0] . " " . $row[1];	


for($i = 2; $i < 6; $i++)
{
	
	$_SESSION["shipping".$labels[$i - 1]] = $row[$i];
	$_SESSION['progress'] +=  4;
	$_SESSION["billing".$labels[$i - 1]] =  $row[$i + 4];	

	//echo($_SESSION["shipping".$labels[$i]] . " " . $_SESSION["billing".$labels[i]] . "<br>");
}

	$_SESSION["shipping".$labels[5]] = $row[10];
	$_SESSION["billing".$labels[5]] =  $row[10];

	$_SESSION['progress'] = 24;

?>