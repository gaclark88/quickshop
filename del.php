<?php include './models/Account.php';
      include 'session.php';
	$db = new DatabaseLink();
	$a = Account::dbGet($_SESSION['accountId'], $db);
		
	/* Connect to database */
	$con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
	$rs = mysql_select_db("clargr1", $con) or die("Could not connect select $con database");
	$query = "";

	/* Fetch categories to list in the sidebar */
	$query = ("DELETE FROM `accounts` WHERE id=" . $a->id);
	mysql_query($query, $con) or die("Could not execute query '$query'");

	echo("<script>location.href=\"index.php\"</script>");
?>