<?php include './models/Model.php';
      include 'session.php';
	
	$orders = $_POST['orders'];

	$db = new DatabaseLink();

	$orders_rows = Model::dbGetBy("id", $orders[0], "orders", $db);

	/* Connect to database */
	$con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
	$rs = mysql_select_db("clargr1", $con) or die("Could not connect select $con database");
	$query = "";

	while($row = mysql_fetch_assoc($orders_rows)) {
		/* Fetch categories to list in the sidebar */
		$query = ("UPDATE `orders` SET status=4 WHERE id=" . $row['id']);
		mysql_query($query, $con) or die("Could not execute query '$query'");
	}

	echo("<script>location.href=\"vieworders.php\"</script>");
?>
