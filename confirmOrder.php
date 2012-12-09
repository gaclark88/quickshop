<?php include "session.php"; ?>
<?php 
/*
*confirmOrder.php
*proccesses the order, and stores all the information in the correct table of the DB
*/

header("location: checkout.php");

//connect to the database
$con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
$rs = mysql_select_db("clargr1", $con) or die("Could not connect select $db database");
$query = "";
$row = array();

//passed in variables
$curU = $_SESSION['accountId'];
$progress = $_SESSION['progress'];

//variables
$cart = array();
$quanities = array();
$size = 0;
$total =0;
$fail = 1;

$query = ("SELECT product_id FROM `cart_items` WHERE account_id = '$curU' " );
$result = mysql_query($query, $con) or die("Could not execute query '$query'");
		
//get size of the cart
while($row = mysql_fetch_array($result))
{
	$cart[$size] = $row[0];
	$size++;
}
	
/*
Check if all items are still in stock while proccessing.
*/
for($i = 0; $i < $size; $i++)
{
	$query = ("SELECT amount FROM `cart_items` WHERE account_id = '$curU' AND product_id=" . $cart[$i] );
	$result = mysql_query($query, $con) or die("Could not execute query '$query'");
	$row = mysql_fetch_array($result);

	$quanity = $row[0];

	$query = ("SELECT name, price, inventory FROM `products` WHERE id=" . $cart[$i] );
	$result = mysql_query($query, $con) or die("Could not execute query '$query'");
	$row = mysql_fetch_array($result);
				
	$name = $row[0];
	$price = $row[1];
	$quanityLeft = $row[2];
				
	if($quanityLeft == 0 or $quanityLeft < $quanity)
	{
		$fail = 0;
	}
	else
	{
		$total = $total + $price*$quanity;
	}
}

//set progress to none incase of failure.
$_SESSION['progress'] = -10;
$order = -1;

/*
insert a new entry ito the table, and retrieve the new order ID
*/
if($fail != 0)
{
	$all = $total + $total*.06 + $_SESSION['shipping'];
	
	$fields = array($_SESSION['shippingAddress'],
	$_SESSION['shippingCity'],
	$_SESSION['shippingZip'],
	$_SESSION['shippingState'],
	$_SESSION['creditnumber'],
	$_SESSION['creditcode'],
	$_SESSION['creditname'],
	$_SESSION['shippingPhone'],
	$_SESSION['billingAddress'],
	$_SESSION['billingCity'],
	$_SESSION['billingZip'],
	$_SESSION['billingState'],
	$_SESSION['shippingName'],
	$_SESSION['billingName'],
	$_SESSION['billingPhone'],
	$_SESSION['shipping'],
	$_SESSION['creditdate']
	);
	
	$query = 
		("INSERT INTO orders (
		account_id,
		shipping_address,
		shipping_city,	 
		shipping_zip, 
		shipping_state,
		credit_num,
		credit_sec,
		credit_name,
		phone, 
		billing_address, 
		billing_city,
		billing_zip,
		billing_state,
		shipping_name,
		billing_name,
		billing_phone,	
		subtotal,
		shipping_price,
		total_amount,
		credit_exp) 

		VALUES (
		'$curU',
		'$fields[0]',
		'$fields[1]',
		'$fields[2]',
		'$fields[3]',
		'$fields[4]',
		'$fields[5]',
		'$fields[6]',
		'$fields[7]',
		'$fields[8]',
		'$fields[9]',
		'$fields[10]',
		'$fields[11]',
		'$fields[12]',
		'$fields[13]',
		'$fields[14]',
		'$total',
		'$fields[15]',
		'$all',
		'$fields[16]')");
	
	$result = mysql_query($query, $con) or die("Could not execute query '$query'");

	$query = ("SELECT id FROM `orders` WHERE account_id='$curU'");
	$result = mysql_query($query, $con) or die("Could not execute query '$query'");
	
	while($row = mysql_fetch_array($result))
	{
		$order = $row[0];
	}


	$_SESSION['progress'] = 100;


}


/*
Loop through everything in the order.
if everything is still in stock,
add it to the order_product table
remove amount from stock.
remove from cart
repeat per item in cart.
*/
for($i = 0; $i < $size; $i++)
{

	if($fail != 0)
	{
		$query = ("SELECT amount FROM `cart_items` WHERE account_id = '$curU' AND product_id=" . $cart[$i] );
		$result = mysql_query($query, $con) or die("Could not execute query '$query'");
		$row = mysql_fetch_array($result);

		$quanity = $row[0];

		$query = ("SELECT name, price, inventory FROM `products` WHERE id=" . $cart[$i] );
		$result = mysql_query($query, $con) or die("Could not execute query '$query'");
		$row = mysql_fetch_array($result);
				
		$name = $row[0];
		$price = $row[1];
		$quanityLeft = $row[2];

		$query = ("INSERT INTO order_products (order_id, product_id, amount) VALUES ($order, $cart[$i], $quanity)");
		$result = mysql_query($query, $con) or die("Could not execute query '$query'");
		//$row = mysql_fetch_array($result);

		$query = ("SELECT inventory FROM `products` WHERE id=" . $cart[$i] );
		$result = mysql_query($query, $con) or die("Could not execute query '$query'");
		$row = mysql_fetch_array($result);
		$a = $row[0] - $quanity;

		$query = ("UPDATE `products` SET inventory = $a WHERE id=" . $cart[$i]  );
		$result = mysql_query($query, $con) or die("Could not execute query '$query'");

		$query = ("DELETE FROM `cart_items` WHERE account_id=   '$curU' AND product_id=" . $cart[$i]  );
		$result = mysql_query($query, $con) or die("Could not execute query '$query'");



		
	}				

}

?>