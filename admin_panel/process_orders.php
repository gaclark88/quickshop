<?php include 'admin_session.php'; ?>
<html>
<head>

<?php include 'header_template.php' ?>

<title>Process Orders</title>

</head>

<body>

<?php include 'body_template.php'?>

<?php

include_once '../models/Model.php';

$conn = new DatabaseLink();

$orders = $_POST['order'];

if(!$orders){
		echo "<div class = 'row'><div class = 'span8 offset2'>";
		echo "<div class='alert alert-error'><h5>No orders were selected. Please select at least one order to process.<h5></div>";
		echo "</div>";
}
else{

$orders_rows = Model::dbGetAllInList("client_orders", "id", $orders, $conn);
$status_rows = Model::dbGetAll("order_status", $conn);
$status_arr = array();

while($row = mysql_fetch_assoc($status_rows)){
	$status_arr[$row['name']] = $row['id'];
}

?>

<div class = 'row'><div class = 'span12'>
<table class = 'table table-bordered'>
<thead>
<tr>
<th>Order Num</th>
<th>New Status</th>
<th>Tracking #</th>
<th>Quant.</th>
<th>Cust. Name</th>
<th>Shipping Address</th>
</tr>
<thead>
<tbody>
<form name = "commit_order" action = "commit_orders.php" method = "POST">

<?php

while($row = mysql_fetch_assoc($orders_rows)){
		
		
	echo "<tr>";
	echo "<td>".$row[id]."</a></td>";
	echo "<td><select name='order_status[]'><option value='$row[id] $row[status_id]'>".$row['status']."</option>";
		foreach($status_arr as $key => $id ){
			if($id != $row['status_id']){
				echo "<option value='$row[id] $id'>$key</option>";
			}
		};
	echo "</select></td>";
	echo "<td><input type = text name = 'tracking_num[]' value = '$row[tracking_num]'></td>";
	// echo "<td>".$row['product_name']."</td>";
	echo "<td>".$row['quantity']."</td>";
	echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
	echo "<td>$row[shipping_address], $row[shipping_city], $row[shipping_state], $row[shipping_zip]</td>";
	
	echo "</tr>";
}


echo "</tbody>";
echo "</table>";
echo "<br><button type = 'submit'  class = 'btn btn-primary'>Save changes and update new status</button>";
echo "</form>";
echo "</div></div>";

}
$conn->disconnect();
?>

<?php include 'end_template.php'?>
</body>
</html>