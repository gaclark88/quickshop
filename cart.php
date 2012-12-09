<?php include "session.php"; ?>

<?php 
/*
*cart.php
*Displays the cart that is stored
*
*/

/* Connect to database */

	//Connect to the database
	$con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
	$rs = mysql_select_db("clargr1", $con) or die("Could not connect select $db database");
	$query = "";
	$row = array();

	//variables
	$curU = $_SESSION['accountId'];
	$cart = array();
	$quanities = array();
	$size = 0;
	$total =0;
	$outofstock = 0;

	//fetch the cart for the user
	$query = ("SELECT product_id FROM `cart_items` WHERE account_id = '$curU' " );
	$result = mysql_query($query, $con) or die("Could not execute query '$query'");
	//$row = mysql_fetch_array($result);

	//fetch the item ids and the size
	while($row = mysql_fetch_array($result))
	{
		$cart[$size] = $row[0];
		$size++;
       }
	
	//if size is 0, the cart is empty, else display cart
	if($size == 0)
	{
		echo("Cart Is Empty");
	}
	else
	{
		//display headers
		echo("<form method =\"post\" action=\"updateCart.php\">");
		echo("<font size = 5><u><b> Shopping Cart </u/b><br><br></font>");

		//display each item of the cart
		for($i = 0; $i < $size; $i++)
		{
			if($size != 0)
			{
			
				//fetch the amount an item from the cart
				$query = ("SELECT amount FROM `cart_items` WHERE account_id = '$curU' AND product_id=" . $cart[$i] );
				$result = mysql_query($query, $con) or die("Could not execute query '$query'");
				$row = mysql_fetch_array($result);

				$quanity = $row[0];

				//fetch the file info from the db
				$query = ("SELECT name, price, inventory FROM `products` WHERE id=" . $cart[$i] );
				$result = mysql_query($query, $con) or die("Could not execute query '$query'");
				$row = mysql_fetch_array($result);
				
				$name = $row[0];
				$price = $row[1];
				$quanityLeft = $row[2];
				
				//fetch the image
				$query = ("SELECT file_data FROM `images` WHERE product_id =" . $cart[$i]);
                            $result = mysql_query($query, $con) or die("Could not execute query '$query'");
                            $row = mysql_fetch_array($result);
				

				//display the image, name, and price
				echo("
 					<fieldset>
			
						     
                                <img src=\"data:image/jpeg;base64," . base64_encode( $row[0] ) . "\" width=\"75\" height=\"75\">


    					<label><a href=\"productPage.php?product_id=". $cart[$i] . "\">$name</a><br>");

				echo("Price: $" . $price . " <br>");				

				//if an item is out of stock, mark it as soo, and set the boolean to true.
				if($quanityLeft == 0)
				{
					echo("<font color=\"red\">Out of Stock </font><style=\"margin-top:20px\"><a href=\"removeFromCart.php?id=" . $cart[$i] . "\"><button class=\"btn btn-small\" type=\"button\">remove</button></a>
");
					$outofstock = 1;
				}
				else
				{

					//doesnt allow a user to have more than the inventory, prints out an appropriate error
					if($quanity > $quanityLeft)
					{
						//echo("<font color=\"red\">Update exceeds stock</font>");
						$quanities[$i] = "<input class=\"input-large\" type=\"text\" value=\"" . $quanity . "\" name=\"$cart[$i]\">";
						echo($quanities[$i]);

						echo("
						<style=\"margin-top:20px\"><a href=\"removeFromCart.php?id=" . $cart[$i] . "\"><button class=\"btn btn-small\" type=\"button\">remove</button></a>
						<font color=\"red\">Quanity cannot exceed stock, only " . $quanityLeft . " left.</font>
   						</label>
  						</fieldset>
						");
						//echo("");

						$outofstock = 1;

					}
					else
					{

						$quanities[$i] = "<input class=\"input-mini\" type=\"text\" value=\"" . $quanity . "\" name=\"$cart[$i]\">";
						echo($quanities[$i]);

						echo("
						<style=\"margin-top:20px\"><a href=\"removeFromCart.php?id=" . $cart[$i] . "\"><button class=\"btn btn-small\" type=\"button\">remove</button></a>
	
   						</label>
  						</fieldset>
						");
					}

				}
	
				//adds to the total price
				$total = $total + $quanity * $price;
				echo("<hr><br>");
			
			}

		}


		if($outofstock == 0)
			echo("<input type=\"submit\" value=\"Update\" /></form><hr>");
		else
			echo("<input type=\"submit\" value=\"Update\" /><span class=\"label label-warning\">will take all invalid items out of cart</span></p></form><hr>");
		
		echo("Subtotal: $" . $total);
		

		//clears all the session variables.
		$_SESSION['progress'] = -1;
		$_SESSION['checkoutError'] = "";

		$_SESSION['billingName'] = "";
		$_SESSION['shippingName'] = "";

		$_SESSION['billingAddress'] = "";
		$_SESSION['shippingAddress'] = "";

		$_SESSION['billingCity'] = "";
		$_SESSION['shippingCity'] = "";

		$_SESSION['billingState'] = "";
		$_SESSION['shippingState'] = "";

		$_SESSION['billingZip'] = "";
		$_SESSION['shippingZip'] = "";

		$_SESSION['billingPhone'] = "";
		$_SESSION['shippingPhone'] = "";

		$_SESSION['creditname'] = "";
		$_SESSION['creditnumber'] = "";
		$_session['creditdate'] = "";
		$_SESSION['creditcode'] = "";

		$_SESSION['shipping'] = "";

		//doesnt allow a user to checkout if there are out of stock items in the cart
		if($outofstock == 0)
		{
			echo("<form method = \"post\" action =\"checkout.php\"><input type=\"submit\" value=\"Checkout\"></form>");
		}
		else
		{
			echo("<br><span class=\"label label-important\">Please remove invalid Items before trying to checkout</span></p>");
		}
		
	
	}



?>