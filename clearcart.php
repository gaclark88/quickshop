<?php include "session.php"; ?>
<?php include_once "./models/DatabaseLink.php"; ?>
<?php

header("location: mycart.php");

/* Connect to database */
$db = new DatabaseLink();
$con = $db->connection;
$query = "";
$row = array();

$curU = $_GET['accountId'];

//check if item exists already in users cart, if not, increment.

$query = ("SELECT product_id FROM `cart_items` WHERE account_id =". $curU );
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


$db->disconnect();


?>
