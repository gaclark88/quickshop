<?php include "session.php"; ?>
<?php

//header("location: mycart.php");
$pId = $_GET['id'];

/* Connect to database */
$con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
$rs = mysql_select_db("clargr1", $con) or die("Could not connect select $db database");
$query = "";
$row = array();

$curU = $_SESSION['accountId'];

//$curU = 1;

//check if item exists already in users cart, if not, increment.

$query = ("SELECT product_id FROM `cart_items` WHERE account_id = '$curU' " );
$result = mysql_query($query, $con) or die("Could not execute query '$query'");
$row = mysql_fetch_array($result);

$cart = array();
$size = 0;
$worked = 0;


if($row[0] != NULL)
{
	echo("row[0] is NOT null <br>");
	
	$cart[$size] = $row[0];
	$size++;
	
	while($row = mysql_fetch_array($result))
	{
		$cart[$size] = $row[0];
		$size++;
       }

	for($i = 0; $i < $size; $i++)
	{
		if($cart[$i] == $pId)
		{	
			$query = ("SELECT amount FROM `cart_items` WHERE account_id = '$curU'" );
			$result = mysql_query($query, $con) or die("Could not execute query '$query'");
			$row = mysql_fetch_array($result);
			$a = $row[0] + 1;

			$query = ("UPDATE `cart_items` SET amount = $a WHERE account_id=   '$curU' AND product_id=" . $pId  );
			$result = mysql_query($query, $con) or die("Could not execute query '$query'");

			$worked = 1;
		}
	}

	if($worked == 0)
	{
		$query = ("INSERT INTO `cart_items` VALUES ($pId, '$curU', 1)");
		$result = mysql_query($query, $con) or die("Could not execute query '$query'");
	}
	
}	
else
{
	$query = ("INSERT INTO `cart_items` VALUES ($pId, '$curU', 1)");
	$result = mysql_query($query, $con) or die("Could not execute query '$query'");
}




?>