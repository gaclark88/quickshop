<?php include 'admin_session.php'; ?>


<html>
<head>

<?php include 'header_template.php' ?>

<title>Client Info</title>

</head>

<body>

<?php include 'body_template.php'?>


<?php>

include_once '../models/Order.php';

$conn = new DatabaseLink();

$data = $_POST['order_status'];
$tracking_nums = $_POST['tracking_num'];
$order_status = array();

echo "<div class = 'row'><div class = 'span8'>";
echo "<div class='alert alert-success'><h5>Orders have been processed! Please check their status below<h5></div>";

echo "<table class = 'table table-bordered'>";
echo "<thead>";	
echo "<tr>";
echo "<th>Order #</th>";
echo "<th>New Order Status</th>";
echo "<th>Tracking Number</th>";
echo "<th>Message</th></tr>";
echo "</thead>";
echo "<tbody>";
foreach($data as $key => $row){
	list($order_id, $status) = explode(" ", $row);
	//$order_status[$order] = $status;
	$order = new Order(array("status" => $status));
	$order->id = $order_id;
	
	$order->fields['tracking_num'] = $tracking_nums[$key];
	//echo $order->id . "=>" . $order->fields['status_id'] . "<br>";
	$status = $order->dbUpdate($conn);
	
	echo "<tr>";
	

		echo "<td>".$order->id."</td>";
		echo "<td>".$order->fields['status']."</td>";
		echo "<td>".$order->fields['tracking_num']."</td>";
	if($status){
		echo "<td>Successfully updated</td>";
	}
	else{
		echo "<td>Counld not edit. Please try again</td>";
	}
	echo "</tr>";
	
	
}
echo "</body";
echo "</table>";
echo "</div></div>";
?>

<?php
$conn->disconnect();


?>

<?php include 'end_template.php'?>
	
	</body>
</html>