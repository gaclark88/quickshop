<?php include 'admin_session.php'; ?>


<html>
<head>

<?php include 'header_template.php' ?>

<title>Client Info</title>

</head>

<body>

<?php include 'body_template.php'?>


<?php>

//include files and establish db link
include_once '../models/Order.php';

$conn = new DatabaseLink();

//receive post variables
$data = $_POST['order_status'];
$tracking_nums = $_POST['tracking_num'];
$order_status = array();

//create success message
echo "<div class = 'row'><div class = 'span8'>";
echo "<div class='alert alert-success'><h5>Orders have been processed! Please check their status below<h5></div>";

//create table for new order statuses and status messages
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
	//create new order
	list($order_id, $status) = explode(" ", $row);
	$order = new Order(array("status" => $status));
	$order->id = $order_id;
	
	//error checking
	if($tracking_nums[$key] == ''){
		$tracking_nums[$key] = 'Not available';
	}
	$order->fields['tracking_num'] = $tracking_nums[$key];
	//update order info to db
	$status = $order->dbUpdate($conn);
	
	echo "<tr>";
	
		//print updated info
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
//close connection to db
$conn->disconnect();


?>

<?php include 'end_template.php'?>
	
	</body>
</html>