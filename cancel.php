<?php include './models/Model.php';
      include 'session.php';
	
	//get the order to be cancelled
	$orders = $_POST['orders'];

	//connect to the database
	$db = new DatabaseLink();
	$orders_rows = Model::dbGetBy("id", $orders[0], "orders", $db);

	/* Connect to database (again) */
	$con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
	$rs = mysql_select_db("clargr1", $con) or die("Could not connect select $con database");
	$query = "";

	while($row = mysql_fetch_assoc($orders_rows)) {
		//update the order to "cancelled"
		$query = ("UPDATE `orders` SET status=4 WHERE id=" . $row['id']);
		mysql_query($query, $con) or die("Could not execute query '$query'");
	}

	//go to account manager
	echo("<script>location.href=\"vieworders.php\"</script>");
?>
