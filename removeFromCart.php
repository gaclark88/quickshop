<?php include "session.php"; ?>
<?php include_once "./models/DatabaseLink.php"; ?>
<?php
/*
*RemoveFromCart.php
*removes an item from the cart
*
*/

//redirect
header("location: mycart.php");

//passed in variables
$pId = $_GET['id'];
$curU = $_SESSION['accountId'];


/* Connect to database */
$db = new DatabaseLink();
$con = $db->connection;
$query = "";
$row = array();

$query = ("SELECT product_id FROM `cart_items` WHERE account_id = '$curU' " );
$result = mysql_query($query, $con) or die("Could not execute query '$query'");
$row = mysql_fetch_array($result);

$cart = array();
$size = 0;
$worked = 0;

/*
If user has a card, get the size of the cart,
if the item matches the item to be removed,
decrement it by one,
if the item amount = 0,
remove it completely.
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
		if($cart[$i] == $pId)
		{	
			$query = ("SELECT amount FROM `cart_items` WHERE account_id = '$curU' AND product_id=" . $pId );
			$result = mysql_query($query, $con) or die("Could not execute query '$query'");
			$row = mysql_fetch_array($result);
			$a = $row[0] - 1;

			if($a > 0)
			{
				$query = ("UPDATE `cart_items` SET amount = $a WHERE account_id=   '$curU' AND product_id=" . $pId  );
				$result = mysql_query($query, $con) or die("Could not execute query '$query'");
			}
			else
			{
				$query = ("DELETE FROM `cart_items` WHERE account_id=   '$curU' AND product_id=" . $pId  );
				$result = mysql_query($query, $con) or die("Could not execute query '$query'");
			}
		}
	}

	
}	





?>
