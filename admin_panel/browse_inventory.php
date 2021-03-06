<?php include 'admin_session.php'; ?>


<html>
	<head>
	
	<?php include 'header_template.php' ?>
	
	<title>Browse Inventory</title>
	
	</head>
	<body>
	<?php include 'body_template.php'?>
<?php

//include files and establish db link

include '../models/Product.php';
	
$conn = new DatabaseLink();

//find all product info 
$products = Product::dbGetAll("products_details", $conn);



?>
<div class = 'row'><div class = 'span12'>
<table  class = 'table table-bordered table-hover'>

<tr>
<th>Select Item</th>
<th>Product Id #</th>
<th>Product Name</th>
<th>Category</th>
<th>Price/Each</th>
<th>Quantity Available</th>

</tr>

<form name = "edit_item" id = 'target' action = "edit_item.php" method = "POST">

<?php
 //print the product information in a table
foreach($products as $product){
	echo "<tr>";
	echo "<td><label class = 'radio offset1'><input type = 'radio' name = 'id' value = ".$product->id."></label></td>";
	echo "<td>".$product->id."</td>";
	echo "<td>".$product->fields['name']."</td>";
	echo "<td>".$product->misc."</td>";
	echo "<td>$".$product->fields["price"]."</td>";
	echo "<td>".$product->fields["inventory"]."</td>";		
	echo "</tr>";
}

?>

</table>
<br>
<button type = "submit"  class = "btn btn-primary">Click to edit</button>
</form>
</div>
</div>
<?php
//close db connection
$conn->disconnect();
?>
<?php include 'end_template.php'?>
</body>
</html>