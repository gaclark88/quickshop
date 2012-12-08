<?php include './models/Account.php';
      include 'session.php';

	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['inputEmail'];
	$phone = $_POST['phone'];

	$db = new DatabaseLink();
	$a = Account::dbGet($_SESSION['accountId'], $db);

	$a->fields['first_name'] = $fname;
	$a->fields['last_name']  = $lname;
	$a->fields['email']      = $email;
	$a->fields['phone']      = $phone;

	$a->dbSave($db);

	echo("<script>location.href=\"accountmgr.php\"</script>");
?>
