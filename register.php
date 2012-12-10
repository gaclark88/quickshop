<?php include './models/Account.php';
      include 'session.php';
	
	//get field information
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['inputEmail'];
	$phone = $_POST['phone'];
	$pass  = $_POST['inputPassword'];
	$cpass = $_POST['confirmPassword'];

	//connect to the database
	$db = new DatabaseLink();
	$isemail = Account::dbCheckPwd($email, $pass, $db);

	//make sure the passwords are equal
	if ($pass != $cpass)
		echo("<script>location.href=\"registerform.php?passerr=1\"</script>");
	//make sure the email address is unique in the db
	else if ($isemail !== null)
		echo("<script>location.href=\"registerform.php?emailerr=1\"</script>");
	else {
		//create the account using form info
		$fields = array ( "first_name" => $fname,
				"last_name" => $lname,
				"email" => $email,
				"phone" => $phone,
				"password" => $pass
				);

		$a = new Account($fields);
		$db = new DatabaseLink();
		//encrypt the password and save the account
		$a->fields["password"] = Account::hashPassword($pass);
		$a->dbSave($db);

		//set the session cookie as the account id to log this user in
		$_SESSION['accountId'] = $a->id;

		//go to account manager
		echo("<script>location.href=\"accountmgr.php\"</script>");
	}
?>
