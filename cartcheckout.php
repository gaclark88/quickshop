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
	$progress = $_SESSION['progress'];

	//$step = $_GET['step'];
	//echo($step);
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
			"Date", 
			"Code");

	$query = ("SELECT first_name, last_name, shipping_address, shipping_city, shipping_zip, phone, billing_address, billing_city, billing_zip, billing_state, shipping_state FROM `accounts` WHERE id =" . $curU );
	$result = mysql_query($query, $con) or die("Could not execute query '$query'");
	$row = mysql_fetch_array($result);

	


	$placeholder = array("John Doe", "1000 Hilltop Circle", "Baltimore", "Maryland", "21250", "United States Of America", "1231231234", "John Doe", "1234567812345678", "June", "01", "123"
			,"John Doe", "1234123412341234", "01/13", "123"
			);

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

	if($progress < 0)
	{
		
		
		echo("Please fill in Shipping and Billing information, if Billing address is the same as Shipping address, click the checkbox above next.<br><br>");
	
		if($row[0] != "" and $row[3] != "")
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

	if($progress >= 0 and $progress < 24)
	{

		if($row[0] != "" and $row[3] != "")
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
			
			
				
			if($_SESSION["shipping".$labels[$i]] == "" or $_SESSION["billing".$labels[$i]] == "")
			{
				echo("			
				<input type=\"text\" value=\"" . $_SESSION["shipping".$labels[$i]] . "\" name=\"".$labels[$i]."\" id=\"".$labels[$i]."\" /></label>
     				 <input type=\"text\" value=\"". $_SESSION["billing".$labels[$i]] .  "\" name=\"b$labels[$i]\" id=\"b". $labels[$i] . "\" />
				<span class=\"label label-important\">Please fill in Both Shipping and Billing Fields Correctly</span></p>");
			}
			else
			{
				echo("			
				<input type=\"text\" value=\"" . $_SESSION["shipping".$labels[$i]] . "\" name=\"".$labels[$i]."\" id=\"".$labels[$i]."\" /></label>
     				 <input type=\"text\" value=\"". $_SESSION["billing".$labels[$i]] .  "\" name=\"b$labels[$i]\" id=\"b". $labels[$i] . "\" />
				</p>");
			}

		}


		echo("<input type=\"checkbox\" name=\"same\" value=\"Yes\"> Shipping Same as Billing<br>");
		echo("<input type=\"submit\" value=\"Next\"></form>");


		
	}


	
	//shipping method
	if($progress == 24)
	{
		echo("Please fill in Payment information<br><br>");
	
		echo("	 <form method = \"post\" action =\"checkcheckout.php\">");
	
		echo("<p class=\"container\"><label2>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<u><b>Payment Information</b></u> </label2>
     			
			</p>");


		for($i = 7; $i < 11; $i++)
		{

			echo("<p class=\"container\"><label for=\"name1\">$labels[$i]</label>
				<input type=\"text\" placeholder=\"" . $placeholder[$i] . "\" name=\"".$labels[$i]."\" id=\"".$labels[$i]."\" /></label>
     				 
				</p>");
				


		}


		echo("<input type=\"submit\" value=\"Next\"></form>");

	}

	//review
	if($progress == 75)
	{
		echo("<font size = 5><u><b>Shipping and Payment Information</u/b><br><br></font>");

		echo("<form method = \"post\" action =\"checkout.php\"><input type=\"submit\" value=\"Next\"></form>");

	}

	//display order
	if($progress == 100)
	{
		echo("<font size = 5><u><b>Shipping and Payment Information</u/b><br><br></font>");

		echo("<form method = \"post\" action =\"checkout.php\"><input type=\"submit\" value=\"Next\"></form>");

	}







?>