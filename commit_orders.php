<html>
<header>
<title>Process Orders</title>
</header>
<body>

<?php>

include 'models/Order.php';

$conn = new DatabaseLink();

$data = $_POST['order_status'];
$order_status = array();

foreach($data as $row){
	list($order_id, $status) = explode(" ", $row);
	//$order_status[$order] = $status;
	$order = new Order(array("status" => $status));
	$order->id = $order_id;
	//echo $order->id . "=>" . $order->fields['status_id'] . "<br>";
	$order->dbUpdate($conn);
}

echo "<br><p>Orders have been successfully processed!</p>";
echo "<br><a href = 'admin_panel.php'>Go Back to Admin Panel</a>";

?>

<?php
$conn->disconnect();


?>

</body>
</html>