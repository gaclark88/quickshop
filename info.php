<?php include './models/Account.php';
      include 'session.php';

	//get info from fields
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['inputEmail'];
	$phone = $_POST['phone'];

	//connect to database
	$db = new DatabaseLink();
	$a = Account::dbGet($_SESSION['accountId'], $db);

	//set database fields to test field info
	$a->fields['first_name'] = $fname;
	$a->fields['last_name']  = $lname;
	$a->fields['email']      = $email;
	$a->fields['phone']      = $phone;

	$a->dbSave($db);

	//go to account manager
	echo("<script>location.href=\"accountmgr.php\"</script>");
?>
