<?php include './models/Account.php';
      include 'session.php';
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['inputEmail'];
	$phone = $_POST['phone'];
	$pass  = $_POST['inputPassword'];
	$cpass = $_POST['confirmPassword'];

	$db = new DatabaseLink();
	$isemail = Account::dbCheckPwd($email, $pass, $db);

	if ($pass != $cpass)
		echo("<script>location.href=\"registerform.php?passerr=1\"</script>");
	else if ($isemail !== null)
		echo("<script>location.href=\"registerform.php?emailerr=1\"</script>");
	else {
		$fields = array ( "first_name" => $fname,
				"last_name" => $lname,
				"email" => $email,
				"phone" => $phone,
				"password" => $pass
				);

		$a = new Account($fields);
		$db = new DatabaseLink();
		$a->fields["password"] = Account::hashPassword($pass);
		$a->dbSave($db);

		$_SESSION['accountId'] = $a->id;

		echo("<script>location.href=\"accountmgr.php\"</script>");
	}
?>
