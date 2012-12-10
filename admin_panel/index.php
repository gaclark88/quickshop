<?php include 'admin_session.php'; ?>


<html>
	<head>
	
	<?php include 'header_template.php' ?>
	
	<title>QuickShop Admin Panel</title>
	</head>
	<body>

	<?php include 'body_template.php'?>
	<div class = 'row'><div class = 'span8 offset2'>
	<p>	<a class= "btn btn-large btn-block btn-primary" href = "browse_inventory.php">MANAGE INVENTORY</a>	</p>
	<p>	<a class= "btn btn-large btn-block btn-primary" href = "manage_orders.php">MANAGE ORDERS</a>	</p>
	<p>	<a class= "btn btn-large btn-block btn-primary" href = "add_item.php">ADD NEW PRODUCT</a>	</p>
	<p>	<a class= "btn btn-large btn-block btn-primary" href = "add_category.php">ADD / CHANGE CATEGORY</a>	</p>
	<p>	<a class= "btn btn-large btn-block btn-primary" href = "view_client_info.php">VIEW CLIENT INFORMATION</a>	</p>
	</div></div>
	

	<?php include 'end_template.php'?>
	</body>
</html>