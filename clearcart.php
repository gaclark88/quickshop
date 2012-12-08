<?php include "session.php"; ?>
<?php

header("location: mycart.php");

/* Connect to database */
$con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
$rs = mysql_select_db("clargr1", $con) or die("Could not connect select $db database");
$query = "";
$row = array();

$curU = $_GET['accountId']

//check if item exists already in users cart, if not, increment.

$query = ("SELECT product_id FROM `cart_items` WHERE account_id = '$curU' " );
$result = mysql_query($query, $con) or die("Could not execute query '$query'");
$row = mysql_fetch_array($result);

$cart = array();
$size = 0;
$worked = 0;


if($row[0] != NULL)
{
	$cart[$size] = $row[0];
	$size++;
	
	while($row = mysql_fetch_array($result))
	{
		$cart[$size] = $row[0];
		$size++;
       }

	for($i = 0; $i < $size; $i++)
	{

		$query = ("SELECT amount FROM `cart_items` WHERE account_id = '$curU' AND product_id=" . $pId );
		$result = mysql_query($query, $con) or die("Could not execute query '$query'");
		$row = mysql_fetch_array($result);

		$query = ("DELETE FROM `cart_items` WHERE account_id=   '$curU' AND product_id=" . $pId  );
		$result = mysql_query($query, $con) or die("Could not execute query '$query'");
	
	}

	
}	





?>