<html>
<header>
<title>Add New Product</title>
</header>

<body>

<form method = POST enctype="multipart/form-data" action = 'commit_item.php'  name 'add_product'>
	
	<table>
	<tr><td>Product Name</td> <td><input type = 'text' size = '30' maxLength = '252' name = 'name'></td></tr>
	
	<?php
	include '/models/Category.php';
	
	$conn = new DatabaseLink();
	//find all categories 
	$categories = Category::dbGetAll($conn);

	echo "<tr><td>Category</td><td><select name ='category'> ";	
	foreach($categories as $category){

		echo "<option value = $category->id>".$category->fields['name']." </option>";
	}
	echo "</td></tr>";
	
	$conn->disconnect();
	?>
	
	<tr><td>Price Per Item</td> <td><input type = 'text' size = '30' maxLength = '252' name = 'price'></td></tr>
	<tr><td>Quantity</td> <td><input type = 'text' size = '30' maxLength = '252' name = 'inventory'></td></tr>
	</table>
	<br>
	Enter Description Below: <br><br>
	<textarea cols = 40 rows = 5 name = 'description'  maxLength = 50000></textarea>
	
	<br><br>
	
	Select an image to upload: <input type="file" name="img" id = "img">
	<br><br>
	<input type = submit value = 'Save Changes and Add New Item'>
</form>

	

</body>
</html>