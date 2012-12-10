<?php include 'admin_session.php'; ?>
<html>
<head>
		<!--Include template file-->
<?php include 'header_template.php' ?>

<title>Process Orders</title>

</head>

<body>
		<!--Include template file-->
<?php include 'body_template.php'?>

<?php

//include files and establish db link
include_once '../models/Model.php';

$conn = new DatabaseLink();

//receive post variables
$orders = $_POST['order'];

//error checking
if(!$orders){
		echo "<div class = 'row'><div class = 'span8 offset2'>";
		echo "<div class='alert alert-error'><h5>No orders were selected. Please select at least one order to process.<h5></div>";
		echo "</div>";
}
else{

//get order info from different views
$orders_rows = Model::dbGetAllInList("client_orders", "id", $orders, $conn);
$status_rows = Model::dbGetAll("order_status", $conn);
$status_arr = array();

//organize the data from db
while($row = mysql_fetch_assoc($status_rows)){
	$status_arr[$row['name']] = $row['id'];
}

?>

	<!--Create table to process orders-->
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

//loop thru all orders selected and provide user with option to edit some fields
while($row = mysql_fetch_assoc($orders_rows)){
		
	//create a form for order status and tracking number
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
//close connection to database
$conn->disconnect();
?>
		<!--Include template file-->
<?php include 'end_template.php'?>
</body>
</html>