<?php include '../session.php';?>

<html>
	<head>
	
	<?php include 'header_template.php' ?>
	
	<title>View Order</title>
	</head>
	<body>
	<?php include 'body_template.php'?>
<?php

$order_id = $_GET['order_id'];

include_once '../models/Model.php';

$conn = new DatabaseLink();

$row = Model::dbGetAllInList("client_orders", "id", array($order_id), $conn);
$order = mysql_fetch_assoc($row);

?>

<div class = 'row'><div class = 'span8'>
<h4>Invoice</h4>
<table class = 'table table-bordered'>
<?php
	
	echo "<tr><td><strong>Order # :</strong></td><td> $order[id] </td></tr>";
	echo "<tr><td><strong>Status  :</strong></td><td> $order[status] </td></tr>";
	echo "<tr><td><strong>Product Name  :</strong></td><td> $order[product_name] </td></tr>";
	echo "<tr><td><strong>Quantity  :</strong></td><td> $order[quantity] </td></tr>";
	echo "<tr><td><strong>Subtotal  :</strong></td><td>$ $order[subtotal] </td></tr>";
	echo "<tr><td><strong>Shipping Price  :</strong></td><td>$ $order[shipping_price] </td></tr>";
	echo "<tr><td><strong>Total  :</strong></td><td>$ $order[total_amount] </td></tr>";
	echo "<tr><td><strong>Customer Name : </strong></td><td> $order[first_name] $order[last_name] </td></tr>";
	echo "<tr><td><strong>Tracking # :</strong> </td><td> $order[tracking_num] </td></tr>";
	echo "<tr><td><strong>Shipping Address :</strong> </td><td> $order[shipping_address] </td></tr>";
	echo "<tr><td><strong>Shipping City :</strong> </td><td> $order[shipping_city] </td></tr>";
	echo "<tr><td><strong>Shipping State :</strong> </td><td> $order[shipping_state] </td></tr>";
	echo "<tr><td><strong>Shipping Zip:</strong> </td><td> $order[shipping_zip] </td></tr>";
	echo "</table></td></tr>";
	
?>

</div>
</div>

<?php
$conn->disconnect();
?>

	<?php include 'end_template.php'?>
	</body>
</html>