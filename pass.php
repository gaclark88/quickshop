<?php include './models/Account.php';
      include 'session.php';

	//get field info
	$oldpass     = $_POST['oldpass'];
	$newpass     = $_POST['newpass'];	
	$confirmpass = $_POST['confirmpass'];
	
	//connect to the database, get the account, and check the password
	$db = new DatabaseLink();
	$a = Account::dbGet($_SESSION['accountId'], $db);
	$correctPwd = Account::dbCheckPwd($a->fields['email'], $oldpass, $db);

	//make sure the password is correct
	if (!$correctPwd)
		echo("<script>location.href=\"changepass.php?error=1\"</script>");
	else {
		//make sure the passwords match
		if ($newpass != $confirmpass) {
			echo("<script>location.href=\"changepass.php?passerr=1\"</script>");
		} else {
			//encrypt the password and save it
			$a->fields["password"] = Account::hashPassword($newpass);
			$a->dbSave($db);

			//go to account manager
			echo("<script>location.href=\"accountmgr.php\"</script>");
		}
	}
?>
