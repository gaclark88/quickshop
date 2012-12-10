<?php include '../models/Admin.php';
      include 'admin_session.php';
	$email = $_POST['email'];
	$pass  = $_POST['pass'];	
	
	$db = new DatabaseLink();
	$correctPwd = Admin::dbCheckPwd($email, $pass, $db);

	if ($correctPwd === null)
		echo("<script>location.href=\"login.php?noemail=1\"</script>");
	else if (!$correctPwd)
		echo("<script>location.href=\"login.php?error=1\"</script>");
	else {
		$db = new DatabaseLink();
		$a = Admin::dbGetByEmail($email, $db);

		$_SESSION['admin_id'] = $a->id;
		
		echo("<script>location.href=\"index.php\"</script>");
	}
?>
