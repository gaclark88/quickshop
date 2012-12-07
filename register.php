<?php include './models/Account.php';
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['inputEmail'];
	$pass  = $_POST['inputPassword'];
	$cpass = $_POST['confirmPassword'];

	/* Connect to database */
	$con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
	$rs = mysql_select_db("clargr1", $con) or die("Could not connect select $con database");
	$query = "";
	$row = array();

	/* get accounts from accounts table */
	$query = ("SELECT email FROM accounts");
	$result = mysql_query($query, $con) or die("Could not execute query '$query'");
	$row = mysql_fetch_array($result);

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
				"password" => $pass
				);

		$a = new Account($fields);
		$db = new DatabaseLink();
		$a->fields["password"] = Account::hashPassword($pass);
		$a->dbSave($db);

		echo("<script>location.href=\"accountmgr.php\"</script>");
	}
?>
