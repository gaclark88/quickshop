<?php include './models/Account.php';
      include 'session.php';
	$email = $_POST['inputEmail'];
	$pass  = $_POST['inputPassword'];	
	
	$db = new DatabaseLink();
	$correctPwd = Account::dbCheckPwd($email, $pass, $db);

	if ($correctPwd === null)
		echo("<script>location.href=\"login.php?noemail=1\"</script>");
	else if (!$correctPwd)
		echo("<script>location.href=\"login.php?error=1\"</script>");
	else {
		$db = new DatabaseLink();
		$a = Account::dbGetByEmail($email, $db);

		$_SESSION['accountId'] = $a->id;

		echo("<script>location.href=\"accountmgr.php\"</script>");
	}
?>
