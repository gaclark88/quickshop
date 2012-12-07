<html>
<header><title>Process Orders</title></header>
<body>
<?php

include 'models/Model.php';

$conn = new DatabaseLink();

$orders = $_POST['order'];

$orders_rows = Model::dbGetAllInList("client_orders", "id", $orders, $conn);
$status_rows = Model::dbGetAll("order_status", $conn);
$status_arr = array();
while($row = mysql_fetch_assoc($status_rows)){
	$status_arr[$row['name']] = $row['id'];
}

?>


<table border = 1>
<tr>
<th width = 75>Order #</th>
<th width = 100>New Status</th>
<th width = 100>Product Name</th>
<th width = 75>Quantity</th>
<th width = 50>Customer Name</th>
<th width = 100>Shipping Address</th>
<th width = 100>Shipping City</th>
<th width = 100>Shipping State</th>
<th width = 100>Shipping Zip</th>
</tr>
<form name = "commit_order" action = "commit_orders.php" method = "POST">

<?php

while($row = mysql_fetch_assoc($orders_rows)){
		
		
	echo "<tr>";
	echo "<td align = 'center'>".$row[id]."</a></td>";
	echo "<td><select name='order_status[]'><option value='$row[id] $row[status_id]'>".$row['status']."</option>";
		foreach($status_arr as $key => $id ){
			if($id != $row['status_id']){
				echo "<option value='$row[id] $id'>$key</option>";
			}
		};
	echo "</select></td>";
	echo "<td>".$row['product_name']."</td>";
	echo "<td>".$row['quantity']."</td>";
	echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
	echo "<td>".$row['shipping_address']."</td>";
	echo "<td>".$row['shipping_city']."</td>";
	echo "<td>".$row['shipping_state']."</td>";
	echo "<td>".$row['shipping_zip']."</td>";
	echo "</tr>";
}
?>

</table>
<br><br>
<input type = submit value = 'Save Changes and Update New Status'>



<?php
$conn->disconnect();
?>
</body>
</html>