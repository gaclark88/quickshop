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

	$curU = $_SESSION['accountId'];
	$cart = array();
	$quanities = array();
	$size = 0;
	$total =0;

	$query = ("SELECT product_id FROM `cart_items` WHERE account_id = '$curU' " );
	$result = mysql_query($query, $con) or die("Could not execute query '$query'");
	//$row = mysql_fetch_array($result);

	while($row = mysql_fetch_array($result))
	{
		$cart[$size] = $row[0];
		$size++;
       }
	
	if($size == 0)
	{
		echo("Cart Is Empty");
	}
	else
	{
		echo("<form method =\"post\" action=\"updateCart.php\">");
		echo("<font size = 5><u><b> Shopping Cart </u/b><br><br></font>");

		for($i = 0; $i < $size; $i++)
		{
			if($size != 0)
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
				
				$query = ("SELECT file_data FROM `images` WHERE product_id =" . $cart[$i]);
                            $result = mysql_query($query, $con) or die("Could not execute query '$query'");
                            $row = mysql_fetch_array($result);
				
				echo("
 					<fieldset>

					     
                                <img src=\"data:image/jpeg;base64," . base64_encode( $row[0] ) . "\" width=\"75\" height=\"75\">


    					<label><a href=\"productPage.php?product_id=". $cart[$i] . "\">$name</a><br>");

				echo("Price: $" . $price . " <br>");				

				if($quanityLeft == 0)
				{
					echo("<font color=\"red\">Out of Stock </font>");
				}
				else
				{

					if($quanity > $quanityLeft)
					{
						//echo("<font color=\"red\">Update exceeds stock</font>");
						$quanities[$i] = "<input class=\"input-large\" type=\"text\" value=\"" . $quanityLeft . "\" name=\"$cart[$i]\">";
						echo($quanities[$i]);

						echo("
						<style=\"margin-top:20px\"><a href=\"removeFromCart.php?id=" . $cart[$i] . "\"><button class=\"btn btn-small\" type=\"button\">remove</button></a>
						<font color=\"red\">Quanity cannot exceed stock</font>
   						</label>
  						</fieldset>
						");
						//echo("");
						$quanity = $quanityLeft;

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

				$total = $total + $quanity * $price;
				echo("<hr><br>");
			
			}

		}

		if($size != 0)
		{
			echo("<input type=\"submit\" value=\"Update\" /></form><hr>");

		
			echo("Subtotal: $" . $total);

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



			echo("<form method = \"post\" action =\"checkout.php\"><input type=\"submit\" value=\"Checkout\"></form>");
		
		}
		
	
	}



?>