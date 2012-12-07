<?php include './models/Account.php';
	$email = $_POST['inputEmail'];
	$pass  = $_POST['inputPassword'];	
	
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
	$correctPwd = Account::dbCheckPwd($email, $pass, $db);

	echo $correctPwd;

	if ($correctPwd === null)
		echo("<script>location.href=\"login.php?noemail=1\"</script>");
	else if (!$correctPwd)
		echo("<script>location.href=\"login.php?error=1\"</script>");
	else
		echo("<script>location.href=\"accountmgr.php\"</script>");
?>
