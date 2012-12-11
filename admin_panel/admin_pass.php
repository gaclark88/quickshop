<?php include 'admin_session.php'; ?>

<?php include '../models/Admin.php';

//get field info
$oldpass     = $_POST['oldpass'];
$newpass     = $_POST['newpass'];	
$confirmpass = $_POST['confirmpass'];
	
	//connect to the database, get the account, and check the password
$db = new DatabaseLink();
$a = Admin::dbGet($_SESSION['admin_id'], $db);
$correctPwd = Admin::dbCheckPwd($a->fields['email'], $oldpass, $db);

	//make sure the password is correct
if (!$correctPwd)
	echo("<script>location.href=\"changepass.php?error=1\"</script>");
else {
	//make sure the passwords match
	if ($newpass != $confirmpass) {
		echo("<script>location.href=\"changepass.php?passerr=1\"</script>");
	} else {
		//encrypt the password and save it
		$a->fields["password"] = Admin::hashPassword($newpass);
		$a->dbSave($db);

		//go to account manager
		echo("<script>location.href=\"index.php\"</script>");
	}
}
?>
