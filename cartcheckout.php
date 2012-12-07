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
		echo("	 <form method = \"post\" action =\"checkcheckout.php\">");
	
	//address and payment
	
	

	$labels = array("Name", 
			"Address", 
			"City", 
			"State", 
			"Zip", 
			"Country", 
			"Phone", 
			"Name on Card", 
			"Number", 
			"Date", 
			"Code");


	$placeholder = array("John Doe", "1000 Hilltop Circle", "Baltimore", "Maryland", "21250", "United States Of America", "1231231234", "John Doe", "1234567812345678", "June", "01", "123");

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

		.container h1
		{
			width: 200px;
  			float: left;
		}

		</style>");

	if($progress == 0)
	{
		echo("<p class=\"container\"><h1>Name1: </h1>
     			<h1>Name2: </h1>
			</p>");


		for($i = 0; $i < 7; $i++)
		{

			echo("<p class=\"container\"><label for=\"name1\">$labels[$i]</label>
				<input type=\"text\" placeholder=\"" . $placeholder[$i] . "\" name=\"" . $labels[$i] . " id=\"". $labels[$i] . "\" /></label>
     				 <input type=\"text\" placeholder=\"" . $placeholder[$i] . "\" name=\"" . $labels[$i] . " id=\"". $labels[$i] . "\" />
				</p>");
				


		}


		echo("<input type=\"checkbox\" name=\"same\" value=\"Yes\"> Shipping Same as Billing<br>");
		echo("<input type=\"submit\" value=\"Next\"></form>");

	}

	if($progress > 0 )
	{
		echo("<u><b>Shipping and Payment Information</u> &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <u>Billing Information</u/b><br><br>");
		
		

		
		echo("<input type=\"checkbox\" name=\"same\" value=\"No\"> Shipping Same as Billing<br>");
		echo("<input type=\"submit\" value=\"Next\"></form>");

		
	}


	
	//shipping method
	if($progress == 50)
	{
		echo("<font size = 5><u><b>Shipping and Payment Information</u/b><br><br></font>");

		echo("<form method = \"post\" action =\"checkout.php\"><input type=\"submit\" value=\"Next\"></form>");

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