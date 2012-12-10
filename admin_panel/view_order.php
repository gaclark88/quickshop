<?php include 'admin_session.php'; ?>

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

<div class = 'row'>
	<div class = 'span12'>
		<h3><p class = 'lead'>Order Invoice</p></h3>
	</div>
</div>



<?php
	
	echo "<div class = 'row'>";
	echo "<div class = 'span2'>";
	echo "<strong>Order # :</strong>";
	echo "</div>";
	echo "<div class = 'span7'>";
	echo "$order[id]";
	echo "</div>";	
	echo "</div>";	
	
	echo "<div class = 'row'>";
	echo "<div class = 'span2'>";
	echo "<strong>Status  :</strong>";
	echo "</div>";
	echo "<div class = 'span7'>";
	echo "$order[status]";
	echo "</div>";
	echo "</div>";
	
	echo "<div class = 'row'>";
		echo "<div class = 'span6'>";
			echo "<strong>Ship To:</strong>";
		echo "</div>";
	echo "</div>";
	
	echo "<div class = 'row'>";
		echo "<div class = 'span6'>";
			echo "<address><strong>$order[shipping_name]</strong><br>
							$order[shipping_address]<br>
							$order[shipping_city]<br>
							$order[shipping_state]<br>
							$order[shipping_zip]<br>
			</address>";
		echo "</div>";
	echo "</div>";
	
	echo "<div class = 'row'>";
		echo "<div class = 'span2'>";
			echo "<strong>Tracking Number:</strong>";
		echo "</div>";
		echo "<div class = 'span8'>";
			echo "$order[tracking_num]";
		echo "</div>";
	echo "</div>";
	
	$product_details = Model::dbGetAllInList("order_items_details", "order_id", array($order_id), $conn);
	
	echo "<br>";
	
	echo "<div class = 'row'>";
		
		echo "<div class = 'span7'>";
			echo "<strong>Product Name</strong>";
		echo "</div>";
		
		echo "<div class = 'span1'>";
			echo "<strong>Qty: </strong>";
		echo "</div>";
		
		echo "<div class = 'span2'>";
			echo "<strong>Price/Each</strong>";
		echo "</div>";
		
		echo "<div class = 'span1'>";
			echo "<strong>Total</strong>";
		echo "</div>";
		
	echo "</div>";
	
	while($row = mysql_fetch_assoc($product_details)){
		echo "<div class = 'row'>";
			echo "<div class = 'span7'>";
				echo "$row[name]";
			echo "</div>";
			echo "<div class = 'span1'>";
				echo "$row[quantity]";
			echo "</div>";
			echo "<div class = 'span2'>";
				echo "$$row[price]";
			echo "</div>";
			echo "<div class = 'span1'>";
				echo "$".floatval($row['price']) *$row['quantity'];
			echo "</div>";
		echo "</div>";
	}
	
	echo "<div class = 'row'>";
		
		echo "<div class = 'span7'>";
			echo "";
		echo "</div>";
		 
		echo "<div class = 'span3'>";
			echo "<strong>Subtotal:</strong>";
		echo "</div>";
		
		echo "<div class = 'span1'>";
			echo "$".round(floatval($order['subtotal']), 1);
		echo "</div>";
		
	echo "</div>";
	
	echo "<div class = 'row'>";
		
		echo "<div class = 'span7'>";
			echo "";
		echo "</div>";
		 
		echo "<div class = 'span3'>";
			echo "<strong>Shipping Price:</strong>";
		echo "</div>";
		
		echo "<div class = 'span1'>";
			echo "$$order[shipping_price]";
		echo "</div>";
		
	echo "</div>";
	
	
	echo "<div class = 'row'>";
		
		echo "<div class = 'span7'>";
			echo "";
		echo "</div>";
		 
		echo "<div class = 'span3'>";
			echo "<strong>Tax:</strong>";
		echo "</div>";
		
		echo "<div class = 'span1'>";
			echo "$".round(floatval($order['subtotal'])*0.06, 2);
		echo "</div>";
		
	echo "</div>";

	
		echo "<div class = 'row'>";
		
		echo "<div class = 'span7'>";
			echo "";
		echo "</div>";
		 
		echo "<div class = 'span3'>";
			echo "<strong>Total:</strong>";
		echo "</div>";
		
		echo "<div class = 'span1'>";
			echo "$".round(floatval($order['total_amount']), 1);
		echo "</div>";
		
	echo "</div>";



	
?>


<?php
$conn->disconnect();
?>

	<?php include 'end_template.php'?>
	</body>
</html>