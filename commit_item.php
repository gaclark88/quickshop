<?php

include '/models/Product.php';

$conn = new DatabaseLink();

$change_flag = $_POST['change_flag'];
$product_id = $_POST['product_id'];


$product_fields = array("name" => $_POST['name'],
			"description" 	=> $_POST['description'],
			"category_id" 	=> $_POST['category'],
			"price" 		=> $_POST['price'],
			"inventory"		=> $_POST['inventory']);

$img_fields = array("filename" => $_FILES['img']['name'],
					"mime_type" => $_FILES['img']['type'],
					"size" => $_FILES['img']['size'],
					"product_id" => $product->id,
					"file_data" => file_get_contents($_FILES["img"]["tmp_name"]));

if($change_flag != 'true'){
	//echo "I better not be here";
	$product = new Product($product_fields);
	$product->dbInsert($conn);
						
	$image = new Image($img_fields);
	$image->fields['product_id'] = $product->id;
	$image->dbInsert($conn);

	$product->fields['image_id'] = $image->id;
	$product->dbUpdate($conn);
	$conn->disconnect();

	echo "<br><p>Product has been successfully added to database!</p>";
	echo "<br><a href = 'admin_panel.php'>Go Back to Admin Panel</a>";
}

else{

	$product = Product::dbGet($product_id, $conn);
	//query returns nothing if image is not there, and you try to edit item with new image
	$image = $product->dbGetImage($conn);
	
	//if image is not there, create it; else edit its fields
	if(!$image->id){
		$image = new Image($img_fields);
		$image->fields['product_id'] = $product->id;
		$image->dbInsert($conn);
	}
	else{
		if($img_fields['filename']){
			//echo "i get here";
			foreach($img_fields as $field => $value){
				$image->fields[$field] = $value;
			}
		}
	}
	
	foreach($product_fields as $field => $value){
		$product->fields[$field] = $value;
	}


	
	$product->dbUpdate($conn);
	
	//TO-DO make sure that image exists
	$image->fields['product_id'] = $product->id;
	$image->dbUpdate($conn);

	echo "<br><p>Product has been successfully edited!</p>";
	echo "<br><a href = 'admin_panel.php'>Go Back to Admin Panel</a>";
}
?>