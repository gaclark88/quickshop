<?php include './models/Account.php';
      include 'session.php';

	//get the form information
	$email = $_POST['inputEmail'];
	$pass  = $_POST['inputPassword'];	
	
	//connect to db and check the password
	$db = new DatabaseLink();
	$correctPwd = Account::dbCheckPwd($email, $pass, $db);

	//if dbCheckPwd returns null, the email doesn't exist
	if ($correctPwd === null)
		echo("<script>location.href=\"login.php?noemail=1\"</script>");
	//if the password is wrong, that's another error
	else if (!$correctPwd)
		echo("<script>location.href=\"login.php?error=1\"</script>");
	else {
		$db = new DatabaseLink();
		$a = Account::dbGetByEmail($email, $db);

		//change the session cookie to the accound id
		$_SESSION['accountId'] = $a->id;

		//go to account manager
		echo("<script>location.href=\"accountmgr.php\"</script>");
	}
?>
