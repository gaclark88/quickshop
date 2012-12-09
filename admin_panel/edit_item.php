<?php include '../session.php'; ?>

<html>
	<head>
	
	<?php include 'header_template.php' ?>
	
	<title>Edit Item</title>
	</head>
	<body>
	<?php include 'body_template.php'?>

	
<div class = 'row'><div class = 'span8'>
	
<form method = POST class = 'form-horizontal' enctype="multipart/form-data" action = 'commit_item.php'  name 'add_product'>

<input type = 'hidden' name = 'change_flag' value = 'true'>

<?php

$product_id = $_POST['id'];

include '../models/Product.php';
include '../models/Category.php';

$conn = new DatabaseLink();

$product = Product::dbGet($product_id, $conn);
$category = Category::dbGet($product->fields['category_id'], $conn);


$categories = Category::dbGetAll($conn);

echo "<input type = 'hidden' name = 'product_id' value =".$product_id." >";

	echo "<div class='control-group'>";
    echo "<label class='control-label' >Product Name</label>";
    echo "<div class='controls'>";
	echo "<input type = 'text' size = '100' maxLength = '500' name = 'name' value ='".$product->fields['name']."'>";
	echo "</div>";
	echo "</div>";
	
	echo "<div class='control-group'>";
    echo "<label class='control-label' >Category</label>";
    echo "<div class='controls'>";
	echo "<select name ='category'> ";	
	echo "<option value = $category->id>".$category->fields['name']."</option>";
	foreach($categories as $cat){
		if($cat->id != $category->id){
			echo "<option value = $cat->id>".$cat->fields['name']." </option>";
		}
	}
	echo "</select>";
	echo "</div>";
	echo "</div>";
	
	echo "<div class='control-group'>";
	echo "<label class='control-label' >Price Per Item</label>";
	echo "<div class='controls'>";
	echo "<input type = 'text' size = '30' maxLength = '252' name = 'price' value = '".$product->fields['price']."'>";
	echo "</div>";
	echo "</div>";

	echo "<div class='control-group'>";
	echo "<label class='control-label' >Inventory</label>";
	echo "<div class='controls'>";
	echo "<input type = 'text' size = '30' maxLength = '252' name = 'inventory' value = '".$product->fields['inventory']."'>";
	echo "</div>";
	echo "</div>";
	
	echo "<div class='control-group'>";
	echo "<label class='control-label' >Enter Description Below</label>";
	echo "<div class='controls'>";
	echo "<textarea cols = 40 rows = 5 name = 'description'  maxLength = 50000>".$product->fields['description']."</textarea>";
	echo "</div>";
	echo "</div>";
	
	echo "<div class='control-group'>";
	echo "<label class='control-label' >Select a <strong>new</strong> image to upload:</label>";
	echo "<div class='controls'>";
	echo "<input type='file' name='img' id = 'img'>";
	echo "</div>";
	echo "</div>";
	

?>

	<button type = "submit"  class = "btn btn-primary offset3">Save changes</button>
	</form>
</body>
</html>