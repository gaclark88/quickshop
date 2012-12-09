<?php include '../session.php'; ?>

<html>
	<head>
	
	<?php include 'header_template.php' ?>
	
	<title>Manage Orders</title>
	</head>
	<body>
	<?php include 'body_template.php'?>

<?php>

include_once '../models/Model.php';

$conn = new DatabaseLink();

$rows = Model::dbGetAll("client_orders", $conn);
?>

<table class = 'table table-bordered table-hover'>
<thead>
<tr>
<th>Process</th>
<th>Order Id #</th>
<th>Customer</th>
<th>Cred Card Last 4</th>
<th>Quantity</th>
<th>Total Amount</th>
<th>Tracking #</th>
<th>Current Status</th>
</tr>
</thead>
<tbody>
<form name = "process_order" action = "process_orders.php" method = "POST">

<?php

while($row = mysql_fetch_assoc($rows)){
		
		
		echo "<tr>";
		echo "<td><label class = 'checkbox offset2'><input type='checkbox' name='order[]' value = ".$row['id']."></label></td>";
		echo "<td><a href='view_order.php?order_id=$row[id]' class='btn btn-link'>$row[id]</a></td>";
		echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
		echo "<td>".$row['credit_4']."</td>";
		echo "<td>".$row['quantity']."</td>";
		echo "<td>$".$row['total_amount']."</td>";
		echo "<td>".$row['tracking_num']."</td>";
		echo "<td>".$row['status']."</td>";
		echo "</tr>";
}

$conn->disconnect();



?>
</tbody>
</table>
<br><button type = "submit"  class = "btn btn-primary">Process Selected Orders</button>
</form>


	<?php include 'end_template.php'?>
	</body>
</html>