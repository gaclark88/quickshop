<?php include './models/Account.php';
      include 'session.php';
	$oldpass     = $_POST['oldpass'];
	$newpass     = $_POST['newpass'];	
	$confirmpass = $_POST['confirmpass'];
	
	$db = new DatabaseLink();
	$a = Account::dbGet($_SESSION['accountId'], $db);
	$correctPwd = Account::dbCheckPwd($a->fields['email'], $oldpass, $db);

	if (!$correctPwd)
		echo("<script>location.href=\"changepass.php?error=1\"</script>");
	else {
		if ($newpass != $confirmpass) {
			echo("<h5>test</h5>");
			echo("<script>location.href\"changepass.php?passerr=1\"</script>");
		} else {
			$a->fields["password"] = Account::hashPassword($newpass);

			$a->dbSave($db);

			echo("<script>location.href=\"accountmgr.php\"</script>");
		}
	}
?>
