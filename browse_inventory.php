<html>
<header>
<title>Browse Inventory</title>
</header>

<body>



<?php>

include 'models/Product.php';
	
$conn = new DatabaseLink();

//find all clients info 
$products = Product::dbGetAll("products_details", $conn);



?>

<table border = 1>
<tr>
<th width = 100>Product Id #</th>
<th width = 100>Product Name</th>
<th width = 100>Category</th>
<th width = 200>Price per Item</th>
<th width = 100>Quantity Available</th>
<th width = 100>Click to edit</th>
</tr>

<?php
 
foreach($products as $product){
	echo "<tr>";
	echo "<td>".$product->id."</td>";
	echo "<td>".$product->fields['name']."</td>";
	echo "<td>".$product->misc."</td>";
	echo "<td>".$product->fields["price"]."</td>";
	echo "<td>".$product->fields["inventory"]."</td>";
	echo "<td><a href = 'edit_item.php?product=$product->id'>Edit Item</a></td>";
		
	echo "</tr>";
}

?>

<?php
$conn->disconnect();
?>

</body>
</html>