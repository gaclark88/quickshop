<?php include "session.php"; ?>
<?php 

header("location: checkout.php?id=0");

$curU = $_SESSION['accountId'];
$_SESSION['progress'] =  0;

	if (isset($_POST['same']))
	{
    		
			
		if($_POST['name'] == "")
		{	
			$_SESSION['checkoutERROR'] = "1";
		}
		else
		{
			$_SESSION['shippingName'] = $_POST['name'];
			$_SESSION['billingName'] = $_POST['name'];
		
			//$_SESSION['progress'] +=  3;
		}

	}
	else
	{
		$_SESSION['shippingName'] = $_POST['name'];
		$_Session['billingName'] = $_POST['bname'];
		//$_SESSION['progress'] +=  3;
	}



?>