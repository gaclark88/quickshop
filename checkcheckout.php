<?php include "session.php"; ?>
<?php 

header("location: checkout.php");

$curU = $_SESSION['accountId'];
$_SESSION['progress'] =  0;

$labels = array(	"Name", 
			"Address", 
			"City", 
			"State", 
			"Zip", 
			"Phone", 
			"Name on Card", 
			"Number", 
			"Date", 
			"Code");

$minimum = array(2, 10, 2, 2, 5, 2, 10); 
	
for($i = 0; $i < 5; $i++)
{
	
	if (isset($_POST["same"]))
	{
    				
		if($_POST[$labels[$i]] != "")
		{
			if(strlen($_POST[$labels[$i]]) >= $minimum[$i])
			{
				$_SESSION["shipping".$labels[$i]] = $_POST[$labels[$i]];
				$_SESSION["billing".$labels[$i]] = $_POST[$labels[$i]];

				$_SESSION['progress'] +=  4;
			}
		}

	}
	else
	{
		if($_POST[$labels[$i]] != "")
		{
			$_SESSION["shipping".$labels[$i]] = $_POST[$labels[$i]];
			$_SESSION['progress'] +=  2;
		}
		
		if($_POST["b" . $labels[$i]] != "")
		{
			$_SESSION["billing".$labels[$i]] = $_POST["b" . $labels[$i]];

			$_SESSION['progress'] +=  2;
		}		

	}

}

?>