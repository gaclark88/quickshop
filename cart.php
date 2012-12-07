<?php include "session.php"; ?>
<?php 
/*
*
*
*
*/

/* Connect to database */
$con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
$rs = mysql_select_db("clargr1", $con) or die("Could not connect select $db database");
$query = "";
$row = array();


/*check if logged in, if so, attach to their cart, else give a random cart*/
function cart()
{
	if (!$cart)
	{
		return '<p>You have no items in your shopping cart</p>';
	}
	else
	{

	}
}

function drawCart()
{
	echo("<a href='addToCart.php?id=1'>1 </a><br>");
	echo("<a href='addToCart.php?id=2'>2 </a><br>");
	echo("<a href='addToCart.php?id=3'>3 </a><br>");
	echo("<a href='addToCart.php?id=4'>4 </a>");
}

/*add the totals n stuff at the bottom, and the jump to the next page*/


?>