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
<th width = 100>Select Item</th>
<th width = 100>Product Id #</th>
<th width = 100>Product Name</th>
<th width = 125>Category</th>
<th width = 100>Price per Item</th>
<th width = 100>Quantity Available</th>

</tr>

<form name = "edit_item" action = "edit_item.php" method = "POST">

<?php
 
foreach($products as $product){
	echo "<tr>";
	echo "<td align = 'center'><input type = 'radio' name = 'id' value = ".$product->id."></td>";
	echo "<td>".$product->id."</td>";
	echo "<td>".$product->fields['name']."</td>";
	echo "<td>".$product->misc."</td>";
	echo "<td>$".$product->fields["price"]."</td>";
	echo "<td>".$product->fields["inventory"]."</td>";		
	echo "</tr>";
}

?>

</table>
<br><input type = 'submit' value = 'Click to Edit'>
</form>

<?php
$conn->disconnect();
?>

</body>
</html>