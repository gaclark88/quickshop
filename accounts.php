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

	/* check to see if account exists with given email */
	$inTable = false;
	do {
		if ($email == $row[0])
			$inTable = true;
	} while($row = mysql_fetch_array($result));

	$db = new DatabaseLink();
	$a = Account::dbGetByEmail($email, $db);
	$correctPwd = $a->checkPwd($pass);
	$correctPwd = Account::dbCheckPwd($email, $pass, $db);

	echo("<p>$inTable<br>$correctPwd</p>");
?>
