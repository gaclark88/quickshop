<?php include "session.php"; ?>
<?php

/*
*addToCart.php
*takes in a product ID and adds it to the users cart
*
*/


/*Redirect*/
header("location: mycart.php");

/*passed in variables*/
$pId = $_GET['id'];
$curU = $_SESSION['accountId'];


/* Connect to database */
$con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
$rs = mysql_select_db("clargr1", $con) or die("Could not connect select $db database");
$query = "";
$row = array();




$query = ("SELECT product_id FROM `cart_items` WHERE account_id = '$curU' " );
$result = mysql_query($query, $con) or die("Could not execute query '$query'");
$row = mysql_fetch_array($result);

$cart = array();
$size = 0;
$worked = 0;

//if the user has a cart, else, make them a cart
if($row[0] != NULL)
{
	$cart[$size] = $row[0];
	$size++;
	
	//Retrieve the ids from the cart
	while($row = mysql_fetch_array($result))
	{
		$cart[$size] = $row[0];
		$size++;
       }

	//iterate through the cart
	for($i = 0; $i < $size; $i++)
	{
		//if the item exists in the cart, increment by one
		if($cart[$i] == $pId)
		{	
			$query = ("SELECT amount FROM `cart_items` WHERE account_id = '$curU' AND product_id=" . $pId );
			$result = mysql_query($query, $con) or die("Could not execute query '$query'");
			$row = mysql_fetch_array($result);
			$a = $row[0] + 1;

			$query = ("UPDATE `cart_items` SET amount = $a WHERE account_id=   '$curU' AND product_id=" . $pId  );
			$result = mysql_query($query, $con) or die("Could not execute query '$query'");

			$worked = 1;
		}
	}

	//if the item isnt in the cart, just add it to cart
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