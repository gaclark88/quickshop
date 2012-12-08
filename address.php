<?php include './models/Account.php';
      include 'session.php';

	$shipaddress = $_POST['shipaddress'];
	$shipcity    = $_POST['shipcity'];
	$shipstate   = $_POST['shipstate'];
	$shipzip     = $_POST['shipzip'];

	$db = new DatabaseLink();
	$a = Account::dbGet($_SESSION['accountId'], $db);

	$a->fields['shipping_address'] = $shipaddress;
	$a->fields['shipping_city']    = $shipcity;
	$a->fields['shipping_state']   = $shipstate;
	$a->fields['shipping_zip']     = $shipzip;

	if ($_POST['same'] == "true") {
		$a->fields['billing_address'] = $shipaddress;
		$a->fields['billing_city']    = $shipcity;
		$a->fields['billing_state']   = $shipstate;
		$a->fields['billing_zip']     = $shipzip;
	} else {
		$a->fields['billing_address'] = $_POST['billaddress'];
		$a->fields['billing_city']    = $_POST['billcity'];
		$a->fields['billing_state']   = $_POST['billstate'];
		$a->fields['billing_zip']     = $_POST['billzip'];
	}

	$a->dbSave($db);

	echo("<script>location.href=\"accountmgr.php\"</script>");
?>
