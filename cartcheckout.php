<?php include "session.php"; ?>
<?php include_once "./models/DatabaseLink.php" ?>

<?php 
/*
*cartCheckout.php
*procedures through the cart checkout procedure
*
*/

/* Connect to database */

	 
	$db = new DatabaseLink();
	$con = $db->connection;
	$query = "";
	$row = array();

	$curU = $_SESSION['accountId'];
	$progress = $_SESSION['progress'];


	//progress bar
	echo(" <div class=\"progress\">
		<div class=\"bar\" style=\"width: ". $progress . "%;\"></div>
		 </div>
		");
	
	
	//address and payment
	
	

	$labels = array("Name", 
			"Address", 
			"City", 
			"State", 
			"Zip", 
			"Phone", 
			"Name on Card", 
			"Number", 
			"Expiration Date", 
			"Security Code");

	$credit = array("name", "number", "date", "code");

	//checks if the user is a guest or logged in, if logged in, present option to use stored address
	if(is_numeric($curU))
	{
 		$query = ("SELECT first_name, last_name, shipping_address, shipping_city, shipping_zip, phone, billing_address, billing_city, billing_zip, billing_state, shipping_state FROM `accounts` WHERE id =" . $curU );
		$result = mysql_query($query, $con) or die("Could not execute query '$query'");
		$row = mysql_fetch_array($result);
	}

	

	//placeholders for input boxes
	$placeholder = array("John Doe", "1000 Hilltop Circle", "Baltimore", "MD", "21250", "1231231234", 
			"John Doe", "1234123412341234", "01/13", "123"
			);

	//label attributes
	echo("<style type=\"text/css\">
		.container 
		{
			width: 100%;
  			overflow: hidden;
		}

		.container label
		{
  			width: 100px;
  			float: left;
		}

		.container label2
		{
  			width: 350px;
  			float: left;
		}


		</style>");

	//first encounter with the checkoutpage, no refreshes
	if($progress == -1)
	{
		
		/*
		print header,
		check if the user has a stored address
		print it out and give option to use it
		print labels for all the fields
		give option for "is same as billing" check box.
		print next button
		*/

		echo("Please fill in Shipping and Billing information, if Billing address is the same as Shipping address, click the checkbox above next.<br><br>");
	
		if($row[0] != "" and $row[1] != "" and $row[2] != "" and $row[3] != "" and $row[10] != "" and $row[4] != "" and $row[5])
		{
			echo("Stored Address: <br>");
			
			echo("<b>" . $row[0] . " " . $row[1] . ", " . $row[2] . ", " . $row[3] . ", " . $row[10] . ", " . $row[4]. ", " . $row[5] . "<b><br>" );


			echo("<form method = \"post\" action =\"useAddress.php\"><input type=\"submit\" value=\"Use this address\"></form><br><br>");
		}

		echo("	 <form method = \"post\" action =\"checkcheckout.php\">");
	
		echo("<p class=\"container\"><label2>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<u><b>Shipping Information</b></u> </label2>
     			<label2>&nbsp&nbsp&nbsp<u><b>Billing Information</b></u> </label2>
			</p>");


		for($i = 0; $i < 6; $i++)
		{

			echo("<p class=\"container\"><label for=\"name1\">$labels[$i]</label>
				<input type=\"text\" placeholder=\"" . $placeholder[$i] . "\" name=\"".$labels[$i]."\" id=\"".$labels[$i]."\" /></label>
     				 <input type=\"text\" placeholder=\"" . $placeholder[$i] . "\" name=\"b$labels[$i]\" id=\"b". $labels[$i] . "\" />
				</p>");
				


		}


		echo("<input type=\"checkbox\" name=\"same\" value=\"Yes\"> Shipping Same as Billing<br>");
		echo("<input type=\"submit\" value=\"Next\"></form>");

	}

	/*
	incase of repeats/refreshes of the page.
	
	print header,
	check if the user has a stored address
	print it out and give option to use it
	print labels for all the fields
	give option for "is same as billing" check box.
	print next button
	put star next to any line that is not filled in for both fields.

	*/
	if($progress >= 0 and $progress < 24)
	{

		if($row[0] != "" and $row[1] != "" and $row[2] != "" and $row[3] != "" and $row[10] != "" and $row[4] != "" and $row[5])
		{
			echo("Stored Address: <br>");
			
			echo("<b>" . $row[0] . " " . $row[1] . ", " . $row[2] . ", " . $row[3] . ", " . $row[10] . ", " . $row[4]. ", " . $row[5] . "<b><br>" );


			echo("<form method = \"post\" action =\"useAddress.php\"><input type=\"submit\" value=\"Use this address\"></form><br><br>");

		}

		echo("	 <form method = \"post\" action =\"checkcheckout.php\">");

		echo("Please fill in Shipping and Billing information, if Billing address is the same as Shipping address, click the checkbox above next.<br><br>");

		echo("<p class=\"container\"><label2>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<u><b>Shipping Information</b></u> </label2>
     			<label2>&nbsp&nbsp&nbsp<u><b>Billing Information</b></u> </label2>
			</p>");

		for($i = 0; $i < 6; $i++)
		{

			
			

	
			echo("<p class=\"container\"><label for=\"name1\">$labels[$i]</label>");
			
			
				
			if($_SESSION["shipping".$labels[$i]] == "" and $_SESSION["billing".$labels[$i]] == "")
			{

				echo("			
				<input type=\"text\" placeholder=\"" . $placeholder[$i] . "\" name=\"".$labels[$i]."\" id=\"".$labels[$i]."\" /></label>
     				 <input type=\"text\" placeholder=\"". $placeholder[$i] .  "\" name=\"b$labels[$i]\" id=\"b". $labels[$i] . "\" />
				<span class=\"label label-important\">Please fill in Both Shipping and Billing Fields Correctly</span></p>");
			}
			else if($_SESSION["shipping".$labels[$i]] != "" and $_SESSION["billing".$labels[$i]] != "")
			{
				
				echo("			
				<input type=\"text\" value=\"" . $_SESSION["shipping".$labels[$i]] . "\" name=\"".$labels[$i]."\" id=\"".$labels[$i]."\" /></label>
     				 <input type=\"text\" value=\"". $_SESSION["billing".$labels[$i]] .  "\" name=\"b$labels[$i]\" id=\"b". $labels[$i] . "\" />
				</p>");
				
			}
			else if($_SESSION["shipping".$labels[$i]] == "" and $_SESSION["billing".$labels[$i]] != "")
			{
				echo("			
				<input type=\"text\" placeholder=\"" . $placeholder[$i] . "\" name=\"".$labels[$i]."\" id=\"".$labels[$i]."\" /></label>
     				<input type=\"text\" value=\"". $_SESSION["billing".$labels[$i]] .  "\" name=\"b$labels[$i]\" id=\"b". $labels[$i] . "\" />

				<span class=\"label label-important\">Please fill in Both Shipping and Billing Fields Correctly</span></p>");

			}
			else if($_SESSION["shipping".$labels[$i]] != "" and $_SESSION["billing".$labels[$i]] == "")
			{
				echo("			
				<input type=\"text\" value=\"" . $_SESSION["shipping".$labels[$i]] . "\" name=\"".$labels[$i]."\" id=\"".$labels[$i]."\" /></label>
     				 <input type=\"text\" placeholder=\"". $placeholder[$i] .  "\" name=\"b$labels[$i]\" id=\"b". $labels[$i] . "\" />
				<span class=\"label label-important\">Please fill in Both Shipping and Billing Fields Correctly</span></p>");

			}
			

		}

		echo("<input type=\"checkbox\" name=\"same\" value=\"Yes\"> Shipping Same as Billing<br>");
		echo("<input type=\"submit\" value=\"Next\"></form>");


		
	}


	/*
	print header,
	print labels for all the fields
	print next button
	*/
	if($progress == 24)
	{
		echo("Please fill in Payment information<br><br>");
	
		echo("	 <form method = \"post\" action =\"checkPayment.php\">");
	
		echo("<p class=\"container\"><label2>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<u><b>Payment Information</b></u> </label2>
     			
			</p>");


		for($i = 6; $i < 10; $i++)
		{

			echo("<p class=\"container\"><label for=\"name1\">$labels[$i]</label>
				<input type=\"text\" placeholder=\"" . $placeholder[$i] . "\" name=\"".$credit[$i-6]."\" id=\"".$credit[$i-6]."\" /></label>
     				 
				</p>");
				


		}


		echo("<input type=\"submit\" value=\"Next\"></form>");

	}

	/*
	print header,
	print labels for all the fields
	print next button
	put star next to any field NOT filled in
	*/
	if($progress > 24 and $progress < 44 )
	{
		echo("Please fill in Payment information<br><br>");
	
		echo("	 <form method = \"post\" action =\"checkPayment.php\">");
	
		echo("<p class=\"container\"><label2>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<u><b>Payment Information</b></u> </label2>
     			
			</p>");


		for($i = 6; $i < 10; $i++)
		{
			
			echo("<p class=\"container\"><label for=\"name1\">$labels[$i]</label>");

			if($_SESSION["credit".$credit[$i-6]] == "")
			{
				echo("			
				<input type=\"text\" placeholder=\"" . $placeholder[$i] . "\" name=\"".$credit[$i-6]."\" id=\"".$credit[$i-6]."\" /></label>
     				<span class=\"label label-important\">*</span></p>");
			}
			else
			{
				echo("			
				<input type=\"text\" value=\"" . $_SESSION["credit".$credit[$i-6]] . "\" name=\"".$credit[$i-6]."\" id=\"".$credit[$i-6]."\" /></label>
     				</p>");
			}

				


		}


		echo("<input type=\"submit\" value=\"Next\"></form>");

	}



	/*
	print three radio buttons for shipping
	default to standard shipping.
	print next button
	*/
	if($progress == 45 or $progress == 44)
	{
		echo("<font size = 5><u><b>Select Shipping Rate</u/b><br><br></font>");



		echo("<Form name =\"form1\" Method =\"Post\" ACTION =\"shippingRate.php\">
		<class=\"container\"><label for='radio'><Input type = 'Radio' Name ='shipping' value= 'regular' CHECKED/>Standard(5-7) - $4.99</label>
		<label for='radio'><Input type = 'Radio' Name ='shipping' value= 'expedited'>Expedited(2-3) - $9.99</label>
		<label for='radio'><Input type = 'Radio' Name ='shipping' value= 'overnight'>Overnight - $24.99</label><br>
		<P>
		<Input type = \"Submit\" Name = \"Submit1\" Value = \"Next\">
		</FORM>");


	}


	/*
	review before submiting
	
	print header,
	print shipping header,
	print all shipping info,
	print all billing info,
	print credit header,
	print credit info,
	print cart header,
	print all items in cart,
	print not enough quanity under any item that is being purchased for more than the max inventory,
		exclude said item from the order.

	print subtotal,
	print tax,
	print shipping,
	print total
	print cancel and confirm button

	*/
	if($progress == 75)
	{
		

		echo("<font size = 5><u><b>Review</u/b><br><br></font>");
		
		echo("<font size = 3><b>Shipping</b><br><br></font>");

		echo("<label>Shipping Address: <br>");		
		for($i = 0; $i < 5; $i++)
		{
			echo($_SESSION['shipping'.$labels[$i]] . ", ");
		
		
		}
		echo("USA, " . $_SESSION['shippingPhone']);
		echo("</label><br>");

		echo("<label>Billing Address: <br>");
		for($i = 0; $i < 5; $i++)
		{
			echo($_SESSION['billing'.$labels[$i]] . ", ");
		
		
		}
		echo("USA, " . $_SESSION['billingPhone']);
		echo("</label><br><br><br>");


		echo("<font size = 3><b>Payment</b><br><br></font>");

		
		echo("<label>Name on card:  " . $_SESSION['creditname'] . "</label>");
		echo("<label>Credit Card Number:  " . $_SESSION['creditnumber'] . "</label>");
		echo("<label>Expiration Date:  " . $_SESSION['creditdate'] . "</label>");
		echo("<label>Security code:  " . $_SESSION['creditcode'] . "</label><br><br>");


		

		echo("<font size = 3><b>Order</b><br><br></font>");
		

		$cart = array();
		$quanities = array();
		$size = 0;
		$total =0;
		$outofstock = 0;

		$query = ("SELECT product_id FROM `cart_items` WHERE account_id = '$curU' " );
		$result = mysql_query($query, $con) or die("Could not execute query '$query'");
		

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
					echo("
 						<fieldset>
					     
    						<label>$name<br>");
						echo("<font color=\"red\">Quanity No longer available</font>");

					$outofstock++;
				}
				else
				{
					if($quanity <= $quanityLeft)
					{
						echo("
 						<fieldset>
					     
    						<label>$name<br>");

						echo("Price: $" . $price . " <br>");

						$quanities[$i] = "Quanity: " . $quanity;
						echo($quanities[$i]);
						$total = $total + $quanity * $price;
					}

				}

				
				echo("</fieldset><hr><br>");
			
			}

		}

		

		if($total > 0 and $outofstock ==0)
		{
			$tax = round($total * .06, 2);

			
			
			echo("Subtotal: $" . number_format($total, 2, '.', '') ."<br>");
			echo("Shipping and Handling: $" . $_SESSION['shipping'] . "<br>");

			echo("Tax: $" .  number_format($tax, 2, '.', '') . "<br>");
			$total = $total + $tax + $_SESSION['shipping'];
			echo("Total: " . number_format($total, 2, '.', '') . "<br><br>");
	
		

			echo("</form><form method = \"post\" action =\"confirmOrder.php\">");
			echo("<Input type = \"Submit\" Name = \"Submit1\" Value = \"Confirm\"></form></label>");

			echo("<label>	 <form method = \"post\" action =\"cancelOrder.php\">");
			echo("<Input type = \"Submit\" Name = \"Submit1\" Value = \"Cancel\">");

			
		}
		else
		{
			echo("	 <form method = \"post\" action =\"cancelOrder.php\">");
			echo("<Input type = \"Submit\" Name = \"Submit1\" Value = \"Cancel\">");
			echo("<span class=\"label label-important\">unpurchasable items in order</span></p></form>");
		}

	}

	/*
	review before submiting
	
	print header,
	print shipping header,
	print all shipping info,
	print all billing info,
	print credit header,
	print credit info,
	print cart header,
	print all items in order,
	print subtotal,
	print tax,
	print shipping,
	print total

	*/
	if($progress == 100)
	{
		echo("<font size = 5><u><b>Invoice</u/b><br><br></font>");
		
		echo("<font size = 3><b>Shipping</b><br><br></font>");

		echo("<label>Shipping Address: <br>");		
		for($i = 0; $i < 5; $i++)
		{
			echo($_SESSION['shipping'.$labels[$i]] . ", ");
		
		
		}
		echo("USA, " . $_SESSION['shippingPhone']);
		echo("</label><br>");

		echo("<label>Billing Address: <br>");
		for($i = 0; $i < 5; $i++)
		{
			echo($_SESSION['billing'.$labels[$i]] . ", ");
		
		
		}
		echo("USA, " . $_SESSION['billingPhone']);
		echo("</label><br><br><br>");


		echo("<font size = 3><b>Payment</b><br><br></font>");

		
		echo("<label>Name on card:  " . $_SESSION['creditname'] . "</label>");
		echo("<label>Credit Card Number:  " . $_SESSION['creditnumber'] . "</label>");
		echo("<label>Expiration Date:  " . $_SESSION['creditdate'] . "</label>");
		echo("<label>Security code:  " . $_SESSION['creditcode'] . "</label><br><br>");


		

		echo("<font size = 3><b>Order</b><br><br></font>");
		

		$cart = array();
		$quanities = array();
		$size = 0;
		$total =0;
		


		$query = ("SELECT MAX(id) FROM `orders` WHERE account_id='$curU'");
		$result = mysql_query($query, $con) or die("Could not execute query '$query'");
		$row = mysql_fetch_array($result);
					
		$order = $row[0];

		$query = ("SELECT product_id FROM `order_products` WHERE order_id =  '$order'");
		$result = mysql_query($query, $con) or die("Could not execute query '$query'");
		
		while($row = mysql_fetch_array($result))
		{
			$cart[$size] = $row[0];
			$size++;
      		}
		
		echo("Your order number is : " . $order . "<br><br>");	

		if($size == 0)
		{
			echo("Cart Is Empty");
		}
		else
		{





			for($i = 0; $i < $size; $i++)
			{
				$query = ("SELECT amount FROM `order_products` WHERE order_id = " . $order);
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
					echo("
 						<fieldset>
					     
    						<label>$name<br>");
						echo("<font color=\"red\">Quanity No longer available, excluded from checkout</font>");
				}
				else
				{
					if($quanity <= $quanityLeft)
					{
						echo("
 						<fieldset>
					     
    						<label>$name<br>");

						echo("Price: $" . $price . " <br>");

						$quanities[$i] = "Quanity: " . $quanity;
						echo($quanities[$i]);
						$total = $total + $quanity * $price;
					}

				}

				
				echo("</fieldset><hr><br>");
			
			}

		}

		

		if($total > 0)
		{
			$tax = round($total * .06, 2);

			
			
			echo("Subtotal: $" . number_format($total, 2, '.', '') ."<br>");
			echo("Shipping and Handling: $" . $_SESSION['shipping'] . "<br>");

			echo("Tax: $" .  number_format($tax, 2, '.', '') . "<br>");
			$total = $total + $tax + $_SESSION['shipping'];
			echo("Total: " . number_format($total, 2, '.', '') . "<br><br>");

			


	
		}

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
	}

	/*
		prints out all failed to purchase items.
		and an appropriate error message
	*/
	if($progress == -10)
	{
		echo("<font color=\"red\">Error, checkout failed</font><br><br>");


		$cart = array();
		$quanities = array();
		$size = 0;
		$total =0;

		$query = ("SELECT product_id FROM `cart_items` WHERE account_id = '$curU' " );
		$result = mysql_query($query, $con) or die("Could not execute query '$query'");
		

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

			$quanity = $row[0];

			$query = ("SELECT name, price, inventory FROM `products` WHERE id=" . $cart[$i] );
			$result = mysql_query($query, $con) or die("Could not execute query '$query'");
			$row = mysql_fetch_array($result);
				
			$name = $row[0];
			$price = $row[1];
			$quanityLeft = $row[2];
								

			if($quanityLeft == 0 or $quanityLeft < $quanity)
			{
				echo("
 					<fieldset>
				     
    					<label>$name<br>");
					echo("<font color=\"red\">Quanity No longer available</font>");
			}

				
			

		}

		echo("	</fieldset><hr><br>");
			echo("<font color=\"red\">Order not proccessed.</font>");

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

	}

	

$db->disconnect();




?>
