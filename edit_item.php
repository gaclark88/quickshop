<html>
<header>
<title>Edit Product</title>
</header>

<body>

<form method = POST enctype="multipart/form-data" action = 'commit_item.php'  name 'add_product'>

<input type = 'hidden' name = 'change_flag' value = 'true'>

<?php

$product_id = $_POST['id'];

include 'models/Product.php';
include 'models/Category.php';

$conn = new DatabaseLink();

$product = Product::dbGet($product_id, $conn);
$category = Category::dbGet($product->fields['category_id'], $conn);
//echo $category->fields['name']."<br>";

$categories = Category::dbGetAll($conn);

echo "<input type = 'hidden' name = 'product_id' value =".$product_id." >";

?>

<table>
<tr><td>Product Name</td>

<?php

echo "<td><input type = 'text' size = '100' maxLength = '500' name = 'name' value ='".$product->fields['name']."'></td></tr>";

echo "<tr><td>Category</td><td><select name ='category'> ";	
echo "<option value = $category->id>".$category->fields['name']."</option>";

foreach($categories as $cat){

	if($cat->id != $category->id){
	
		echo "<option value = $cat->id>".$cat->fields['name']." </option>";
	}
}
echo "</td></tr>";

echo "<tr><td>Price Per Item</td> <td><input type = 'text' size = '30' maxLength = '252' name = 'price' value = '".$product->fields['price']."'></td></tr>";

echo "<tr><td>Quantity</td> <td><input type = 'text' size = '30' maxLength = '252' name = 'inventory' value = '".$product->fields['inventory']."'></td></tr>
</table><br>";

echo	"Enter Description Below: <br><br>";
echo "<textarea cols = 40 rows = 5 name = 'description'  maxLength = 50000>".$product->fields['description']."</textarea>";

?>

<br><br>
	
Select a new image to upload: <input type="file" name="img" id = "img">
<br><br>
<input type = submit value = 'Save Changes'>
</body>
</html>