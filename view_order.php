<html>
<header>
<title>View Order Info</title>
</header>
<body>

<?php

$order_id = $_GET['order_id'];

include '/models/Model.php';

$conn = new DatabaseLink();

$row = Model::dbGetAllInList("client_orders", "id", array($order_id), $conn);
$order = mysql_fetch_assoc($row);

?>

<table>
<tr>
<td>
<table>
<?php
	
	echo "<tr><td width = 100>Order # :</td><td> $order[id] </td></tr>";
	echo "<tr><td>Status  :</td><td> $order[status] </td></tr>";
	echo "<tr><td>Product Name  :</td><td> $order[product_name] </td></tr>";
	echo "<tr><td>Quantity  :</td><td> $order[quantity] </td></tr>";
	echo "<tr><td>Subtotal  :</td><td>$ $order[subtotal] </td></tr>";
	echo "<tr><td>Shipping Price  :</td><td>$ $order[shipping_price] </td></tr>";
	echo "<tr><td>Total  :</td><td>$ $order[total_amount] </td></tr>";
	echo "</table></td></tr>";
	echo "<tr><td><br></td></tr>";
	echo "<tr><td><table>";
	echo "<tr><td width = 200>Customer Name : </td><td> $order[first_name] $order[last_name] </td></tr>";
	echo "<tr><td>Shipping Address : </td><td> $order[shipping_address] </td></tr>";
	echo "<tr><td>Shipping City : </td><td> $order[shipping_city] </td></tr>";
	echo "<tr><td>Shipping State : </td><td> $order[shipping_state] </td></tr>";
	echo "<tr><td>Shipping Zip : </td><td> $order[shipping_zip] </td></tr>";
	echo "</table></td></tr>";
	
?>
<?php
$conn->disconnect();
?>

</body>
</html>