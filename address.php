<?php include './models/Account.php';
      include 'session.php';

	//get all the info from the form
	$shipaddress = $_POST['shipaddress'];
	$shipcity    = $_POST['shipcity'];
	$shipstate   = $_POST['shipstate'];
	$shipzip     = $_POST['shipzip'];

	//access the database
	$db = new DatabaseLink();
	$a = Account::dbGet($_SESSION['accountId'], $db);

	//set the database fields to the form fields
	$a->fields['shipping_address'] = $shipaddress;
	$a->fields['shipping_city']    = $shipcity;
	$a->fields['shipping_state']   = $shipstate;
	$a->fields['shipping_zip']     = $shipzip;

	//if "billing address is same as shipping address" box
	//is ticked, the billing info will be the same as the shipping info
	if ($_POST['same'] == "true") {
		$a->fields['billing_address'] = $shipaddress;
		$a->fields['billing_city']    = $shipcity;
		$a->fields['billing_state']   = $shipstate;
		$a->fields['billing_zip']     = $shipzip;
	//otherwise it will get it from the forms
	} else {
		$a->fields['billing_address'] = $_POST['billaddress'];
		$a->fields['billing_city']    = $_POST['billcity'];
		$a->fields['billing_state']   = $_POST['billstate'];
		$a->fields['billing_zip']     = $_POST['billzip'];
	}

	$a->dbSave($db);

	//go back to account manager
	echo("<script>location.href=\"accountmgr.php\"</script>");
?>
