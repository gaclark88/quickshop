<?php include "session.php"; ?>
<?php 
/*
*checkcheckout.php
*error checks the address portion of checkout.
*
*/


//Redirect
header("location: checkout.php");


//passed in variables
$curU = $_SESSION['accountId'];
$_SESSION['progress'] =  0;


//variables
$labels = array(	"Name", 
			"Address", 
			"City", 
			"State", 
			"Zip", 
			"Phone", 
);

$minimum = array(2, 10, 2, 2, 5, 2, 10); 
$maximum = array(100, 100, 100, 2, 6, 15); 

/*
loops through all the fields of shipping information.
if the "same as shipping" is checked, maked sure shipping information is within the bounds.
if within bounds,set the shipping and billing information to the input boxes.
if same is not checked, make sure the input in both fields is within the limits. set the billing and shipping information.
increment the progress bar for each succesfully filled field.
*/	

for($i = 0; $i < 6; $i++)
{
	
	if (isset($_POST["same"]))
	{
    				
		if($_POST[$labels[$i]] != "")
		{
			if(strlen($_POST[$labels[$i]]) >= $minimum[$i] and strlen($_POST[$labels[$i]]) <= $maximum[$i])
			{
				$_SESSION["shipping".$labels[$i]] = $_POST[$labels[$i]];
				$_SESSION["billing".$labels[$i]] = $_POST[$labels[$i]];

				$_SESSION['progress'] +=  4;
			}
		}

	}
	else
	{
		if(strlen($_POST[$labels[$i]]) >= $minimum[$i] and strlen($_POST[$labels[$i]]) <= $maximum[$i])

		{
			$_SESSION["shipping".$labels[$i]] = $_POST[$labels[$i]];
			$_SESSION['progress'] +=  2;
		}
		
		if(strlen($_POST[$labels[$i]]) >= $minimum[$i] and strlen($_POST[$labels[$i]]) <= $maximum[$i])

		{
			$_SESSION["billing".$labels[$i]] = $_POST["b" . $labels[$i]];

			$_SESSION['progress'] +=  2;
		}		

	}

}

?>