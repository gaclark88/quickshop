<?php include 'admin_session.php'; ?>


<html>
	<head>
	<!--Include template file-->
	<?php include 'header_template.php' ?>
	
	<title>QuickShop Admin Panel</title>
	</head>
	<body>
	<!--Include template file-->
	<?php include 'body_template.php'?>
	
	<!--Create main buttons-->
	<div class = 'row'><div class = 'span8 offset2'>
	<p>	<a class= "btn btn-large btn-block btn-primary" href = "browse_inventory.php">MANAGE INVENTORY</a>	</p>
	<p>	<a class= "btn btn-large btn-block btn-primary" href = "manage_orders.php">MANAGE ORDERS</a>	</p>
	<p>	<a class= "btn btn-large btn-block btn-primary" href = "add_item.php">ADD NEW PRODUCT</a>	</p>
	<p>	<a class= "btn btn-large btn-block btn-primary" href = "add_category.php">ADD / CHANGE CATEGORY</a>	</p>
	<p>	<a class= "btn btn-large btn-block btn-primary" href = "view_client_info.php">VIEW CLIENT INFORMATION</a>	</p>
	<p>	<a class= "btn btn-large btn-block btn-primary" href = "admin_changePass.php">CHANGE ADMIN PASSOWRD</a>	</p>
	</div></div>
	
	<!--Include template file-->
	<?php include 'end_template.php'?>
	</body>
</html>