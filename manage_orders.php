<html>
<header>
<title>Manage Orders</title>
</header>

<body>

<?php>

include 'models/Model.php';

$conn = new DatabaseLink();

$rows = Model::dbGetAll("client_orders", $conn);
?>

<table border = 1>
<tr>
<th width = 50>Process</th>
<th width = 100>Order Id #</th>
<th width = 100>Customer</th>
<th width = 150>Cred Card Last 4</th>
<th width = 50>Quantity</th>
<th width = 100>Total Amount</th>
<th width = 100>Current Status</th>
</tr>
<form name = "process_order" action = "process_orders.php" method = "POST">

<?php

while($row = mysql_fetch_assoc($rows)){
		
		
		echo "<tr>";
		echo "<td align = 'center'><input type='checkbox' name='order[]' value = ".$row['id']."></td>";
		echo "<td align = 'center'><a href = 'view_order.php?order_id=$row[id]'>".$row['id']."</a></td>";
		echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
		echo "<td>".$row['credit_4']."</td>";
		echo "<td>".$row['quantity']."</td>";
		echo "<td>$".$row['total_amount']."</td>";
		echo "<td>".$row['status']."</td>";
		echo "</tr>";
}

$conn->disconnect();



?>
</table>
<br><input type = 'submit' value = 'Process Selected Orders'>
</form>


</body>
</html>