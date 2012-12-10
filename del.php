<?php include './models/Account.php';
      include_once "./models/DatabaseLink.php";
      include 'session.php';

	//connect to database and get an account
	$db = new DatabaseLink();
	$a = Account::dbGet($_SESSION['accountId'], $db);
		
	/* Connect to database (again)*/
	$db = new DatabaseLink();
	$con = $db->connection;
	$query = "";

	//delete the account from the accounts table in the database
	$query = ("DELETE FROM `accounts` WHERE id=" . $a->id);
	mysql_query($query, $con) or die("Could not execute query '$query'");

	//go to main screen
	echo("<script>location.href=\"index.php\"</script>");

	$db->disconnect();
?>
