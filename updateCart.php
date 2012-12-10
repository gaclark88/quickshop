<?php include "session.php"; ?>
<?php include_once "./models/DatabaseLink.php"; ?>
<?php
/*
*updateCart.php
*Checks the users cart, and updates the values to match the values inputed by the user into the input boxes.
*/

//redirect
header("location: mycart.php");

/* Connect to database */
$db = new DatabaseLink();
$con = $db->connection;
$query = "";
$row = array();

//passed in variable
$curU = $_SESSION['accountId'];

//check if item exists already in users cart, if not, increment.

$query = ("SELECT product_id FROM `cart_items` WHERE account_id = '$curU' " );
$result = mysql_query($query, $con) or die("Could not execute query '$query'");
$row = mysql_fetch_array($result);

$cart = array();
$size = 0;
$worked = 0;

/*
*If the user has a cart, get the size
*scan through the cart, and if the user inputed 0, remove from cart
*if the user tried to input more quanity than stock, set the the max amount allowed
*set the cart item to the input value.
*/
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

		$query = ("SELECT amount FROM `cart_items` WHERE account_id = '$curU' AND product_id=" . $cart[$i] );
		$result = mysql_query($query, $con) or die("Could not execute query '$query'");
		$row = mysql_fetch_array($result);

		$quanity = $_POST[$cart[$i]];

		$query = ("SELECT name, price, inventory FROM `products` WHERE id=" . $cart[$i] );
		$result = mysql_query($query, $con) or die("Could not execute query '$query'");
		$row = mysql_fetch_array($result);
				
		$name = $row[0];
		$price = $row[1];
		$quanityLeft = $row[2];
		$a = 0;
				
		if($quanityLeft == 0 or $quanityLeft < $quanity)
		{
			$a = $quanityLeft;
		}
		else
		{
			$a = $_POST[$cart[$i]];
		}
		
		if($a > 0)
		{
			$query = ("UPDATE `cart_items` SET amount = $a WHERE account_id= '$curU' AND product_id=" . $cart[$i]  );
			$result = mysql_query($query, $con) or die("Could not execute query '$query'");
		}
		else
		{
			$query = ("DELETE FROM `cart_items` WHERE account_id=   '$curU' AND product_id=" . $cart[$i]  );
			$result = mysql_query($query, $con) or die("Could not execute query '$query'");
		}

	}

	
}	



?>
